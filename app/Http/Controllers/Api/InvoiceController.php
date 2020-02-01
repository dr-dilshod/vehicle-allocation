<?php

namespace App\Http\Controllers\Api;

use App\Invoice;
use App\Item;
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
        $complete_date = "*-".$invoice_month."-".$invoice_day;
        $shipper_id = $request->query('shipper_id') ?: '';
        $matchThese = ['delete_flg' => 0];
        if (!empty($weekday)) {
            $matchThese = array_add($matchThese, 'stack_date', $stack_date);
        } else if (!empty($vehicle_id)) {
            $matchThese = array_add($matchThese, 'vehicle_id', $vehicle_id);
        } else if (!empty($invoice_day)) {
            $matchThese = array_add($matchThese, 'item_completion_date', $complete_date);
        } else if (!empty($shipper_id)) {
            $matchThese = array_add($matchThese, 'shipper_id', $shipper_id);
        }
        $invoiceTable = Item::where($matchThese)
            ->where('down_date', '>=', date("Y-m-d"))
            ->select()
            ->get();
        return response()->json($invoiceTable);
    }
}
