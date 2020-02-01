<?php

namespace App\Http\Controllers\Api;

use App\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * returns the list of invoices based on the query on the invoice list view
     *
     * @param Request $request
     * @return mixed
     */
    public function getInvoiceList(Request $request)
    {
        $weekday = $request->query('weekday') ?: '';
        $vehicle_id = $request->query('vehicle_id') ?: '';
        $invoice_day = $request->query('invoice_day') ?: '';
        $invoice_month = $request->query('invoice_month') ?: '';
        $shipper_id = $request->query('shipper_id') ?: '';
        $matchThese = ['delete_flg' => 0];
        if (!empty($weekday)) {
            $matchThese = array_add($matchThese, 'weekday', $weekday);
        } else if (!empty($vehicle_id)) {
            $matchThese = array_add($matchThese, 'vehicle_id', $vehicle_id);
        } else if (!empty($invoice_day)) {
            $matchThese = array_add($matchThese, 'invoice_day', $invoice_day);
        } else if (!empty($invoice_month)) {
            $matchThese = array_add($matchThese, 'invoice_month', $invoice_month);
        } else if (!empty($shipper_id)) {
            $matchThese = array_add($matchThese, 'shipper_id', $shipper_id);
        }
        $invoiceTable = Item::where($matchThese)->get();
        return response()->json($invoiceTable);
    }
}
