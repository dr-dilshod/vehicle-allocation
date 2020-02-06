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
}
