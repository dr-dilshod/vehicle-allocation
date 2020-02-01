<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Payment;
use App\Shipper;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $result = Payment::where([
            'payment_amount'=>'2000-01-01',
            'delete_flg'=>0
        ])->orderBy('payment_day')->paginate(25);
        return response()->json($result);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShippers(Request $request)
    {
        $shippers = Shipper::select(['shipper_id', 'shipper_name1', 'shipper_name2'])
            ->where('delete_flg',0)
            ->distinct()
            ->get();
        return response()->json($shippers);
    }

}
