<?php

namespace App\Http\Controllers\Api;

use App\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drivers = \DB::table('drivers')
            ->distinct()
            ->select(\DB::raw('drivers.driver_name, SUM(items.item_price) as amount'))
            ->leftJoin('items','drivers.driver_id','=','items.driver_id')
            ->where(['drivers.delete_flg'=>0,'items.delete_flg'=>0])
            ->groupBy('drivers.driver_name')
            ->get();
        return response()->json($drivers);
    }

}
