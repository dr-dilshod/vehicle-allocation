<?php

namespace App\Http\Controllers\Api;

use App\Driver;
use App\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TopController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $today = Carbon::today()->format('Y/m/d');
        $drivers = \DB::table('drivers')
            ->distinct()
            ->select(\DB::raw('drivers.driver_name, SUM(items.item_price) as amount'))
            ->leftJoin('dispatches','drivers.driver_id','=','dispatches.driver_id')
            ->leftJoin('items','dispatches.item_id','=','items.item_id')
            ->where(['drivers.delete_flg'=>0,'items.delete_flg'=>0,'dispatches.delete_flg'=>0,'items.stack_date'=>$today])
            ->groupBy('drivers.driver_name')
            ->get();
        return response()->json($drivers);
    }

    public function getByMonth(Request $request){
        $year = $request->get('year');
        $month = $request->get('month');
        DB::enableQueryLog();
        $drivers = DB::table('drivers')
            ->distinct()
            ->select(DB::raw('drivers.driver_name, SUM(items.item_price) as amount'))
            ->leftJoin('dispatches','drivers.driver_id','=','dispatches.driver_id')
            ->leftJoin('items','dispatches.item_id','=','items.item_id')
            ->where(['drivers.delete_flg'=>0,'dispatches.delete_flg'=>0,'items.delete_flg'=>0])
            ->whereRaw("YEAR(items.stack_date)=? AND MONTH(items.stack_date)=?",[$year,$month])
            ->groupBy('drivers.driver_name')
            ->get();
        return response()->json($drivers);
    }

    public function getAll()
    {
        $drivers = Driver::query()
            ->select('driver_id', 'driver_name')
            ->distinct()
            ->with('dispatches')
            ->where('delete_flg', '=', 0)->get();
        $res = [];
        $amount = 0;
        foreach ($drivers as $driver) {
            foreach ($driver->dispatches as $dispatch) {
                if (intval($dispatch->delete_flg) === 0 && !is_null($dispatch->item) && intval($dispatch->item->delete_flg) === 0) {
                    $amount += $dispatch->item->item_price;
                }
            }
            array_push($res, ['driver_name' => $driver->driver_name, 'amount' => $amount]);
            $amount = 0;
        }
        return response()->json($res);
    }

}
