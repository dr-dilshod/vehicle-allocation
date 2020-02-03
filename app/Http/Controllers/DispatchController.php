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
        $firstDate = $params['date'];
        $dispatch_drivers = \DB::table('dispatches')
            ->select(['dispatches.driver_id','drivers.vehicle_no3','drivers.driver_name'])
            ->distinct()
            ->leftJoin('items','dispatches.item_id','=','items.item_id')
            ->leftJoin('drivers','dispatches.driver_id','=','drivers.driver_id')
            ->where([
                'items.down_date'=>$firstDate,
                'items.delete_flg'=>0,
                'dispatches.delete_flg'=>0,
                'drivers.delete_flg'=>0
            ])
            ->get();
        $result['dispatch_drivers'] = $dispatch_drivers;
        foreach($dispatch_drivers as $driver){
            $day_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->leftJoin('drivers','dispatches.driver_id','=','drivers.driver_id')
                ->where([
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.delete_flg'=>0,
                    'items.down_date'=>$firstDate,
                    'items.delete_flg'=>0,
                ])
                ->whereRaw('dispatches.timezone IN (1,2)')
                ->get();
            $next_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->leftJoin('drivers','dispatches.driver_id','=','drivers.driver_id')
                ->where([
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.timezone'=>Dispatch::TIMEZONE_NEXT_PRODUCT,
                    'dispatches.delete_flg'=>0,
                    'items.down_date'=>$firstDate,
                    'items.delete_flg'=>0,
                ])
                ->get();
            $result['dispatches'][]=[
                'driver_id' => $driver->driver_id,
                'vehicle_no' => $driver->vehicle_no3,
                'driver_name' => $driver->driver_name,
                'items' => $day_items,
                'next_day_items' => $next_items
            ];
        }

        $pdf = \PDF::loadView('dispatch.pdf.print', [
            'params' => $params,
            'dispatches' => $result['dispatches']
        ]);
        return $pdf->download($firstDate.'毎日の発送.pdf');
    }
}
