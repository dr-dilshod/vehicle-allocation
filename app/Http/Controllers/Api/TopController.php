<?php

namespace App\Http\Controllers\Api;

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
        $year = is_numeric($request->get('year')) ? $request->get('year') : '';
        $month = is_numeric($request->get('month')) ? $request->get('month'): '';
        $drivers = DB::select("select distinct drivers.driver_name, SUM(items.item_price) as amount from `drivers` ".
            " left join `dispatches` on (`drivers`.`driver_id` = `dispatches`.`driver_id` and `dispatches`.`delete_flg` = 0) ".
            "left join `items` on (`dispatches`.`item_id` = `items`.`item_id` and `items`.`delete_flg` = 0 and ".
            " YEAR(items.stack_date) = '$year' AND MONTH(items.stack_date) = '$month') where (`drivers`.`delete_flg` = 0) ".
            "group by `drivers`.`driver_name`");
        return response()->json($drivers);
    }

    public function getAll()
    {
        $startDate = Carbon::now();
        $firstDay = $startDate->firstOfMonth()->format('Y-m-d');
        $lastDay = $startDate->lastOfMonth()->format('Y-m-d');
        $drivers = DB::select("select distinct drivers.driver_name, SUM(items.item_price) as amount from `drivers` ".
                " left join `dispatches` on (`drivers`.`driver_id` = `dispatches`.`driver_id` and `dispatches`.`delete_flg` = 0) ".
                "left join `items` on (`dispatches`.`item_id` = `items`.`item_id` and `items`.`delete_flg` = 0 and ".
                " items.stack_date >= '$firstDay' AND items.stack_date <= '$lastDay') where (`drivers`.`delete_flg` = 0) ".
                "group by `drivers`.`driver_name`");
        return response()->json($drivers);
    }

}
