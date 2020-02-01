<?php
/**
 * Created by PhpStorm.
 * User: N0D1R
 * Date: 25-Jan-20
 * Time: 9:16 AM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function registration(Request $request)
    {
        return view('payment.registration');
    }

    public function bk_report(Request $request){
        return view('payment.bk-report');
    }

}
