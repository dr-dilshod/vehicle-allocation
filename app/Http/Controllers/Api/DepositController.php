<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function report(Request $request){
        $shipper = $request->get('shipper');
        $year = $request->get('year');
        $month = $request->get('month');
        $day = $request->get('day');


    }

}
