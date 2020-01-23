<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Invoice index view
     */
    public function index(){
        return view('invoice.index');
    }

    /**
     * Billing month printing
     */
    public function billingMonthPDF(Request $request){
        $params = $request->all();
        $pdf = \PDF::loadView('invoice.pdf.billing_month', [
            'params' => $params,
        ]);
        return $pdf->download('billingMonth.pdf');
    }
}
