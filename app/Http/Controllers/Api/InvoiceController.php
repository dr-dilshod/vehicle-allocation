<?php

namespace App\Http\Controllers\Api;

use App\Deposit;
use App\Invoice;
use App\Item;
use App\Shipper;
use App\Payment;
use App\UnitPrice;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $invoices = DB::table('invoices')
            ->join('items', 'invoices.item_id', '=', 'items.item_id')
            ->get();
        // $matters = Item::where('item_completion_date','>',Carbon::today())->get();
        return response()->json($invoices);
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $all = $request->json()->all();
        $save = false;
        $update = false;

        $updatedInvoices = [];
        $addedInvoices = [];
        foreach ($all as $invoice) {
            if (!isset($invoice['invoice_id']) || is_null($invoice['invoice_id'])) {
                // add validation rules here later
                $invoice['stack_date'] = date('Y-m-d', strtotime($invoice['stack_date']));
                $invoice = collect($invoice)->filter(function ($val, $key) {
                    return !is_null($val);
                })->toArray();
                $item = Item::create($invoice);
                $item_id = $item->item_id;
                if (Carbon::now()->day < 20) {
                    $deadline = Carbon::now()->setDay(20)->format('Y-m-d');
                } else {
                    $deadline = Carbon::now()->endOfMonth()->format('Y-m-d');
                }
                $vehicle = Vehicle::query()->where(['vehicle_no' => $invoice['vehicle_no3']])->first();
                Invoice::firstOrCreate(['item_id'=>$item_id,
                    'shipper_id'=>$invoice['shipper_id'],
                    'vehicle_id'=>$vehicle->vehicle_id,
                    'billing_recording_date'=>date('Y-m-d'),
                    'billing_deadline_date' => $deadline]);
            } else {
                array_push($updatedInvoices, $invoice);
            }
        }

        if (count($updatedInvoices) > 0) {
            $this->validate($request, Item::$updateRules);
            $update = true;
        }
        if ($update) {
            foreach ($updatedInvoices as $invoice) {
                Item::query()->where('item_id', $invoice['item_id'])->update(collect($invoice)->only(['shipper_id', 'driver_id', 'create_id', 'update_id', 'vehicle_id', 'status',
                    'stack_date', 'stack_time', 'down_date', 'down_time', 'down_invoice', 'stack_point', 'down_point',
                    'weight', 'empty_pl', 'item_price', 'item_driver_name', 'vehicle_no3', 'shipper_name', 'item_vehicle',
                    'vehicle_payment', 'item_completion_date', 'highway_cost', 'pay_highway_cost', 'item_remark',
                    'delete_flg', 'created_at', 'updated_at', 'remember_token'])->toArray());
            }
        }
        return response()->json([], 201);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return $invoice;
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->update($request->all());

        return response()->json($invoice, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Invoice::where('item_id',$id)->update(['delete_flg'=>1]);
        return response()->json(null, 204);
    }

    /**
     * returns the list of invoices based on the query on the invoice list view
     *
     * @param Request $request
     * @return mixed
     */
    public function getInvoiceList(Request $request)
    {
        $stack_date = $request->input('stack_date') ?: '';
        $vehicle_id = $request->input('vehicle_id') ?: '';
        $invoice_day = $request->input('invoice_day') ?: '';
        $invoice_month = $request->input('invoice_month') ?: '';
        $shipper_id = $request->input('shipper_id') ?: '';
        $matchThese = ['delete_flg' => 0];
        if (!empty($vehicle_id)) {
            $vehicle = Vehicle::query()->where('vehicle_id', '=', $vehicle_id)->first();
            if (!is_null($vehicle)) {
                $matchThese = array_add($matchThese, 'vehicle_id', $vehicle->vehicle_id);
            }
        }
        if (!empty($invoice_day) && !empty($invoice_month)) {
            $invoice_month .= '-'.$invoice_day;
            $matchThese = array_add($matchThese, 'billing_deadline_date', $invoice_month);
        } else if (!empty($invoice_day) && empty($invoice_month)) {
            $invoice_month = date('Y-m') . '-' . $invoice_day;
            $matchThese = array_add($matchThese, 'billing_deadline_date', $invoice_month);
        }

        if (!empty($shipper_id)) {
            $matchThese = array_add($matchThese, 'shipper_id', $shipper_id);
        }

        $invoices = Invoice::query()->select('item_id')
            ->where($matchThese)->get()->map(function ($e) {
                return $e->item_id;
            });

        $invoiceTable = Item::query()->whereIn('item_id', $invoices);
        if (!empty($stack_date)) {
            $invoiceTable = $invoiceTable->where('stack_date', '=', $stack_date)
                ->where('down_date', '>=', date("Y-m-d"));
        }
        $invoiceTable = $invoiceTable->get();
        return response()->json($invoiceTable);
    }
    /**
     * returns the list of deposits for a specific shipper
     *
     * @param Request $request
     * @return mixed
     */
    public function getDepositList(Request $request)
    {
        $shipper_id = $request->query('shipper_id') ?: '';
        $deposits = Deposit::where('shipper_id','=',$shipper_id)->get();
        return response()->json($deposits);
    }

    /**
     * returns the list of payments for a specific shipper
     *
     * @param Request $request
     * @return mixed
     */
    public function getPaymentList(Request $request)
    {
        $shipper_id = $request->query('shipper_id') ?: '';
        $payments = Payment::where('shipper_id','=',$shipper_id)->get();
        return response()->json($payments);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @return the list of stack points for the dropdown list
     */
    public function stackPoints()
    {
        $stack_points = UnitPrice::query()->select(['price_id', 'stack_point'])
            ->where('delete_flg', 0)
            ->distinct()
            ->orderBy('stack_point', 'ASC')
            ->get();
        return response()->json($stack_points);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @return the list of down points for the dropdown list
     */
    public function downPoints()
    {
        $down_points = UnitPrice::query()->select(['price_id', 'down_point'])
            ->where('delete_flg', 0)
            ->distinct()
            ->orderBy('down_point', 'ASC')
            ->get();
        return response()->json($down_points);
    }

    /**
     * returns the list of shippers for the dropdown list
     *
     * @param Request $request
     * @return mixed
     */
    public function getShipperList(Request $request)
    {
        $shipperIDs = Item::query()->select('shipper_id')->distinct()->get(function($e) {
           return $e->shipper_id;
        });
        $shippers = Shipper::query()->whereIn('shipper_id', $shipperIDs)->get();
        return response()->json($shippers);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVehicleList()
    {
        $vehicleIDs = Item::query()
            ->select('vehicle_id')
            ->distinct()->get(function($e) {
            return $e->vehicle_id;
        });

        $vehicles = Vehicle::query()
            ->select(['vehicle_id', 'vehicle_no', 'company_name'])
            ->whereIn('vehicle_id', $vehicleIDs)
            ->get();
        return response()->json($vehicles);
    }

    /**
     * Billing month printing
     */
    public function billingMonthPDF(Request $request)
    {
        $shipper_id = $request->query('shipper_id') ?: '';
        $billing_month = $request->query('billing_month') ?: '';
        $billing_day = $request->query('billing_day') ?: '';
        $billing_date_array = ['billing_date' => $billing_month." ".$billing_day];

        $shipper_data = $this->getShipperDataForPrinting($shipper_id);
        $items = Item::where('shipper_id', $shipper_id)
            ->get();

        $item_list = [];

        $previous_month_billing = 0;
        $today = Carbon::today();
        foreach ($items as $item) {
            //$completion_date = Carbon::parse($item->item_completion_date);
            //$diff = $today->diffInMonths($completion_date);
            //if ($diff == 1) {
                $previous_month_billing = $previous_month_billing + $item->item_price;
                array_push($item_list, $item);
            //}
        }

        $deposits = Deposit::where('shipper_id', $shipper_id)
            ->where('delete_flg', 0)
            ->get();
        $deposit = 0;
        foreach ($deposits as $dep) {
            $dep_day = Carbon::parse($dep->deposit_day);
            $diff = $today->diffInMonths($dep_day);
            if ($diff == 1) {
                $deposit = $deposit + $dep->deposit_amount;
            }
        }

        $payments = Payment::where('shipper_id', $shipper_id)
            ->where('delete_flg', 0)
            ->get();

        $same_day_sales = 0;
        foreach ($payments as $payment) {
            $pay_day = Carbon::parse($payment->payment_day);
            $diff = $today->diffInMonths($pay_day);
            if ($diff == 1) {
                $same_day_sales = $same_day_sales + $payment->payment_amount;
            }
        }

        $consumption_tax = $previous_month_billing * 0.1;
        $carry_over_amount = $deposit - $same_day_sales;

        $invoice_amount = $previous_month_billing + $deposit - $carry_over_amount;
        $tax_free = $invoice_amount - $same_day_sales - $consumption_tax;
        $offset_discount =$invoice_amount - $deposit - $consumption_tax;

        $calculations = [
            'previous_month_billing' => $previous_month_billing,
            'deposit' => $deposit,
            'same_day_sales' => $same_day_sales,
            'consumption_tax' => $consumption_tax,
            'offset_discount' => $offset_discount,
            'carry_over_amount' => $carry_over_amount,
            'invoice_amount' => $invoice_amount,
            'tax_free' => $tax_free,
        ];

        $pdf = \PDF::loadView('invoice.pdf.billing_month', [
            'calculations' => $calculations,
            'shipper_data' => $shipper_data,
            'item_data' => $item_list,
            'billing' => $billing_date_array]);
        return $pdf->download('billingMonth.pdf');
    }

    /**
     * Fetch shipper data for invoice printing
     */
    public function getShipperDataForPrinting($shipper_id) {
        $shipper = Shipper::where('shipper_id', $shipper_id)
            ->where('delete_flg', 0)
            ->first();

        $shipper_data = [
            'shipper_no' => $shipper->shipper_no,
            'closing_date' => $shipper->closing_date,
            'shipper_name1' => $shipper->shipper_name1,
            'shipper_name2' => $shipper->shipper_name2,
            'address1' => $shipper->address1,
            'address2' => $shipper->address2,
            'postal_code' => $shipper->postal_code,
            'shipper_kana_name1' => $shipper->shipper_kana_name1
        ];
        return $shipper_data;
    }
    /**
     * Billing month printing
     */
    public function billingListPDF(Request $request)
    {
        $shipper_id = $request->query('shipper_id') ?: '';
        $billing_month = $request->query('billing_month') ?: '';
        $billing_day = $request->query('billing_day') ?: '';
        $stack_date = $request->query('stack_date') ?: '';
        $vehicle_id = $request->query('vehicle_id') ?:'';

        $shipper_data = $this->getShipperDataForPrinting($shipper_id);

        $matchThese = ['delete_flg' => 0];
        if (!empty($vehicle_id)) {
            $vehicle = Vehicle::query()->where('vehicle_id', '=', $vehicle_id)->first();
            if (!is_null($vehicle)) {
                $matchThese = array_add($matchThese, 'vehicle_id', $vehicle->vehicle_id);
            }
        }
        if (!empty($billing_day) && !empty($billing_month)) {
            $billing_month .= '-'.$billing_day;
            $matchThese = array_add($matchThese, 'billing_deadline_date', $billing_month);
        } else if (!empty($billing_day) && empty($billing_month)) {
            $billing_month = date('Y-m') . '-' . $billing_day;
            $matchThese = array_add($matchThese, 'billing_deadline_date', $billing_month);
        }

        if (!empty($shipper_id)) {
            $matchThese = array_add($matchThese, 'shipper_id', $shipper_id);
        }

        $invoices = Invoice::query()->select('item_id')
            ->where($matchThese)->get()->map(function ($e) {
                return $e->item_id;
            });

        $item_list = Item::query()->whereIn('item_id', $invoices)
            ->where('stack_date', '=', $stack_date)
            ->where('down_date', '>=', date("Y-m-d"))
            ->get();

        $previous_month_billing = 0;
        foreach ($item_list as $item) {
            $previous_month_billing = $previous_month_billing + $item->item_price;
        }


        $deposits = Deposit::where('shipper_id', $shipper_id)
            ->where('delete_flg', 0)
            ->get();
        $deposit = 0;
        $today = $billing_month.'-'.$billing_day;
        foreach ($deposits as $dep) {
            $dep_day = Carbon::parse($dep->deposit_day);
            $to = Carbon::parse($today);
            $diff = $to->diffInMonths($dep_day);
            if ($diff == 1) {
                $deposit = $deposit + $dep->deposit_day;
            }
        }

        $payments = Payment::where('shipper_id', $shipper_id)
            ->where('delete_flg', 0)
            ->get();

        $same_day_sales = 0;
        foreach ($payments as $payment) {
            $pay_day = Carbon::parse($payment->payment_day);
            $to = Carbon::parse($today);
            $diff = $to->diffInMonths($pay_day);
            if ($diff == 1) {
                $same_day_sales = $same_day_sales + $payment->payment_amount;
            }
        }

        $consumption_tax = $previous_month_billing * 0.1;
        $carry_over_amount = $deposit - $same_day_sales;

        $invoice_amount = $previous_month_billing + $deposit - $carry_over_amount;
        $tax_free = $invoice_amount - $same_day_sales - $consumption_tax;
        $offset_discount =$invoice_amount - $deposit - $consumption_tax;
        $calculations = [
            'previous_month_billing' => $previous_month_billing,
            'deposit' => $deposit,
            'same_day_sales' => $same_day_sales,
            'consumption_tax' => $consumption_tax,
            'offset_discount' => $offset_discount,
            'carry_over_amount' => $carry_over_amount,
            'invoice_amount' => $invoice_amount,
            'tax_free' => $tax_free,
        ];

        $billing_date_array = ['billing_date' => ''];
        $pdf = \PDF::loadView('invoice.pdf.billing_month', [
            'calculations' => $calculations,
            'shipper_data' => $shipper_data,
            'item_data' => $item_list,
            'billing' => $billing_date_array]);
        return $pdf->download('billingList.pdf');
    }

    public function getAggregate()
    {
        $lastMonthBegin = Carbon::today()->setMonths(Carbon::today()->month-1)->setDays(1);
        $lastMonthEnd = Carbon::today()->setMonths(Carbon::today()->month-1)->setDays($lastMonthBegin->daysInMonth)->format('Y-m-d');
        $lastMonthBegin = $lastMonthBegin->format('Y-m-d');

        $lastMonthPayments = Payment::query()
            ->whereDate('payment_day', '<=', $lastMonthEnd)
            ->whereDate('payment_day', '>=', $lastMonthBegin)->get()->all();

        $lastMonthSales = 0;
        $lastMonthDeposits = 0;
        $salesCompilationDate = $lastMonthBegin;
        $sameDaySales = 0;

        foreach ($lastMonthPayments as $payment) {
            $lastMonthSales += doubleval($payment->payment_amount);
            if ($salesCompilationDate < $payment->payment_day) {
                $salesCompilationDate = $payment->payment_day;
            }
            $deposits = Deposit::query()->whereDate('deposit_day', '>=', $lastMonthBegin)
                ->whereDate('deposit_day', '<=', $lastMonthEnd)
                ->where('shipper_id', '=', $payment->shipper_id)->get();
            foreach ($deposits as $deposit) {
                $lastMonthDeposits += doubleval($deposit->deposit_amount);
            }
        }

        $lastMonthTotal = $lastMonthSales + $lastMonthDeposits;
        $consumptionTax = $lastMonthSales * 0.1;

        $thisMonthBegin = Carbon::today()->setDay(1);
        $thisMonthEnd = Carbon::today()->setDay($thisMonthBegin->daysInMonth)->format('Y-m-d');
        $thisMonthBegin = $thisMonthBegin->format('Y-m-d');

        $thisMonthPayments = Payment::query()->whereDate('payment_day', '>=', $thisMonthBegin)
            ->whereDate('payment_day', '<=', $thisMonthEnd)->get()->all();
        $thisMonthSales = 0;
        $thisMonthDeposits = 0;
        foreach ($thisMonthPayments as $payment) {
            $thisMonthSales += doubleval($payment->payment_amount);
            $deposits = Deposit::query()->whereDate('deposit_day', '>=', $thisMonthBegin)
                ->whereDate('deposit_day', '<=', $thisMonthEnd)
                ->where('shipper_id', '=', $payment->shipper_id)->get();
            foreach ($deposits as $deposit) {
                $thisMonthDeposits += doubleval($deposit->deposit_amount);
            }
        }

        return response()->json([
            'lastMonthSales' => number_format($lastMonthSales, 2),
            'lastMonthDeposits' => number_format($lastMonthDeposits, 2),
            'carryover' => number_format($lastMonthDeposits - $lastMonthSales, 2),
            'salesCompilationDate' => date('Y/m/d', strtotime($salesCompilationDate)),
            'consumptionTax' => number_format($consumptionTax, 2),
            'taxFee' => number_format($lastMonthSales - $sameDaySales - $consumptionTax, 2),
            'totalLastMonth' => number_format($lastMonthTotal, 2),
            'totalThisMonth' => number_format($thisMonthSales + $thisMonthDeposits, 2),
            'total' => number_format($thisMonthDeposits + $thisMonthSales + $lastMonthSales + $lastMonthDeposits, 2)
        ]);
    }
}
