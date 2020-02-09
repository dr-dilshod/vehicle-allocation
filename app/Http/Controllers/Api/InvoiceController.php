<?php

namespace App\Http\Controllers\Api;

use App\Deposit;
use App\Invoice;
use App\Item;
use App\Shipper;
use App\Payment;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shipper = $request->get('shipper');
        $matters = Item::where('item_completion_date','>',Carbon::today())->get();
        return response()->json($matters);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = Invoice::create($request->all());
        return response()->json($invoice);
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
        $stack_date = $request->query('stack_date') ?: '';
        $vehicle_id = $request->query('vehicle_id') ?: '';
        $invoice_day = $request->query('invoice_day') ?: '';
        $invoice_month = $request->query('invoice_month') ?: '';
        $shipper_id = $request->query('shipper_id') ?: '';
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

        $invoiceTable = Item::query()->whereIn('item_id', $invoices)
            ->where('stack_date', '=', $stack_date)
            ->where('down_date', '>=', date("Y-m-d"))
            ->get();
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
        $vehicleIDs = Item::query()->select('vehicle_id')->distinct()->get(function($e) {
            return $e->vehicle_id;
        });

        $vehicles = Vehicle::query()->select(['vehicle_id', 'vehicle_no'])->whereIn('vehicle_id', $vehicleIDs)->get();
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
                $deposit = $deposit + $dep->deposit_day;
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
        $offset_discount = 0; // ? don't where it comes from?
        $carry_over_amount = $deposit - $same_day_sales;

        $invoice_amount = $previous_month_billing + $deposit - $carry_over_amount;
        $tax_free = $invoice_amount - $same_day_sales - $consumption_tax;
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


        $items = Item::where('shipper_id', $shipper_id)
            ->where('stack_date', $stack_date)
            ->where('vehicle_id', $vehicle_id)
            ->where('delete_flg', 0)
            ->get();

        $item_list = [];

        $previous_month_billing = 0;
        $today = Carbon::today();
        foreach ($items as $item) {
            $previous_month_billing = $previous_month_billing + $item->item_price;
            array_push($item_list, $item);
        }

        $deposits = Deposit::where('shipper_id', $shipper_id)
            ->where('delete_flg', 0)
            ->get();
        $deposit = 0;
        foreach ($deposits as $dep) {
            $dep_day = Carbon::parse($dep->deposit_day);
            $diff = $today->diffInMonths($dep_day);
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
            $diff = $today->diffInMonths($pay_day);
            if ($diff == 1) {
                $same_day_sales = $same_day_sales + $payment->payment_amount;
            }
        }

        $consumption_tax = $previous_month_billing * 0.1;
        $offset_discount = 0; // ? don't where it comes from?
        $carry_over_amount = $deposit - $same_day_sales;

        $invoice_amount = $previous_month_billing + $deposit - $carry_over_amount;
        $tax_free = $invoice_amount - $same_day_sales - $consumption_tax;
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
