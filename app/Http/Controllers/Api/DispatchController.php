<?php

namespace App\Http\Controllers\Api;

use App\Dispatch;
use App\Driver;
use App\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DispatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = [];
        $firstDate = Carbon::now()->addDay()->format('Y-m-d');
        $secondDate = Carbon::now()->addDays(2)->format('Y-m-d');
        $firstListItems = Item::select(['item_id','driver_id','shipper_id','down_date',
            'down_point','shipper_name','stack_point','weight','empty_pl','item_remark'])
            ->where(['down_date'=>$firstDate,'delete_flg'=>0])
            ->get();
        $secondListItems = Item::with('shipper')->where(['down_date'=>$secondDate,'delete_flg'=>0])->get();
        $result['first_list'] = [
            'date'=>$firstDate,
            'data'=>$firstListItems
        ];
        $result['second_list'] = [
            'date'=>$secondDate,
            'data'=>$secondListItems
        ];
        $drivers = Driver::select('driver_id','driver_name','vehicle_no3')->where(['admin_flg'=>0,'delete_flg'=>0,'search_flg'=>0])->get();
        $result['drivers'] = $drivers;
        return response()->json($result);
    }

    /**
     *
     */
    public function thirdList(Request $request){
        $result = [];
        $drivers = $request->all();
        $result['drivers'] = $drivers;
        return response()->json($result);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $dispatch = Dispatch::create($data);
        return response()->json($dispatch, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
