<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DispatchController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('dispatch.index');
    }

    public function printPdf(Request $request){
        $params = $request->all();
        $pdf = \PDF::loadView('dispatch.pdf.print', [
            'params' => $params,
        ]);
        return $pdf->download('daily_dispatch.pdf');
    }
}
