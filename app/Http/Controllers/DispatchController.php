<?php

namespace App\Http\Controllers;

use App\Dispatch;
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
        $date = $params['date'];
        $dispatches = \DB::table('dispatches')
            ->leftJoin('items','dispatches.item_id','=','items.item_id')
            ->leftJoin('drivers','dispatches.driver_id','=','drivers.driver_id')
            ->where([
                'dispatches.delete_flg'=>0,
                'items.delete_flg'=>0,
            ])
            ->orderBy('drivers.vehicle_type')
            ->orderBy('drivers.vehicle_no3')
            ->get();
        $pdf = \PDF::loadView('dispatch.pdf.print', [
            'params' => $params,
            'dispatches' => $dispatches
        ]);
        return $pdf->download($date.'毎日の発送.pdf');
    }


}
