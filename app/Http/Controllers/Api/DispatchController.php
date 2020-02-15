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
    public function index(Request $request)
    {
        \DB::enableQueryLog(); // Enable query log
        $result = [];

        $firstDate = $request->get('date');
        $firstDate = date('Y/m/d',strtotime($firstDate));
        $secondDate = date('Y/m/d',strtotime($firstDate." +1 day"));
        if(date('w',strtotime($secondDate)) == 0) // if Sunday
            $secondDate = date('Y/m/d',strtotime($secondDate." +1 day"));

        $firstListItems = \DB::table('items')
            ->select(['items.item_id','items.driver_id','items.shipper_id','items.down_date','items.down_time',
            'items.down_point','items.shipper_name','items.stack_point','items.weight','items.empty_pl','items.item_remark'])
            ->where(['items.down_date'=>$firstDate,'items.delete_flg'=>0,'dispatch_status'=>Item::DISPATCH_STATUS_OUT_DISPATCH])
            ->get();
        $secondListItems = \DB::table('items')
            ->select(['items.item_id','items.driver_id','items.shipper_id','items.down_date','items.down_time',
            'items.down_point','items.shipper_name','items.stack_point','items.weight','items.empty_pl','items.item_remark'])
            ->where(['items.down_date'=>$secondDate,'items.delete_flg'=>0,'dispatch_status'=>Item::DISPATCH_STATUS_OUT_DISPATCH])
            ->get();
        $result['first_list'] = [
            'date'=>$firstDate,
            'data'=>$firstListItems
        ];
        $result['second_list'] = [
            'date'=>$secondDate,
            'data'=>$secondListItems
        ];
        $drivers = Driver::select(['driver_id','driver_name','vehicle_no3'])
            ->where([
                'delete_flg'=>0,
            ])
            ->get();
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
        $tableDriverList = [];
        $result['drivers'] = $drivers;
        $result['dispatch_drivers'] = $dispatch_drivers;
        foreach($dispatch_drivers as $driver){
            $morning_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->where([
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.timezone'=>Dispatch::TIMEZONE_MORNING,
                    'dispatches.delete_flg'=>0,
                    'items.down_date'=>$firstDate,
                    'items.delete_flg'=>0,
                ])
                ->get();
            $noon_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->where([
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.timezone'=>Dispatch::TIMEZONE_NOON,
                    'dispatches.delete_flg'=>0,
                    'items.down_date'=>$firstDate,
                    'items.delete_flg'=>0,
                ])
                ->get();
            $next_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
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
                'morning' => $morning_items,
                'noon' => $noon_items,
                'nextProduct' => $next_items
            ];
            $tableDriverList[] = $driver->driver_id;
        }
        $result['tableDriverList'] = $tableDriverList;
        $result['dispatchesSql'] = \DB::getQueryLog();
        return response()->json($result);
    }

    /**
     *
     */
    public function thirdList(Request $request){
        $result = [];
        $data = $request->all();
        $firstDate = $data['firstDate'];
        $drivers = $data['drivers'];
        $dispatch_drivers = [];
        foreach ($drivers as $driver){
            $dispatch_drivers[] = Driver::find($driver);
        }
        foreach($dispatch_drivers as $driver){
            $morning_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->where([
                    'items.down_date'=>$firstDate,
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.timezone'=>Dispatch::TIMEZONE_MORNING,
                    'dispatches.delete_flg'=>0,
                    'items.delete_flg'=>0,
                ])
                ->get();
            $noon_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->where([
                    'items.down_date'=>$firstDate,
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.timezone'=>Dispatch::TIMEZONE_NOON,
                    'dispatches.delete_flg'=>0,
                    'items.delete_flg'=>0,
                ])
                ->get();
            $next_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->where([
                    'items.down_date'=>$firstDate,
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.timezone'=>Dispatch::TIMEZONE_NEXT_PRODUCT,
                    'dispatches.delete_flg'=>0,
                    'items.delete_flg'=>0,
                ])
                ->get();
            $result['dispatches'][]=[
                'driver_id' => $driver->driver_id,
                'vehicle_no' => $driver->vehicle_no3,
                'driver_name' => $driver->driver_name,
                'morning' => $morning_items,
                'noon' => $noon_items,
                'nextProduct' => $next_items
            ];
        }
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
        if($dispatch){
            $stmt = \DB::update('UPDATE items SET dispatch_status=? WHERE item_id=?',[Item::DISPATCH_STATUS_IN_DISPATCH,$dispatch->item_id]);
        }
        return response()->json($dispatch, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dispatch = Dispatch::where(['item_id'=>$id,'delete_flg'=>0])->first();
        if($dispatch){
            $stmt = \DB::update('UPDATE items SET dispatch_status=? WHERE item_id=?',[Item::DISPATCH_STATUS_OUT_DISPATCH,$id]);
            $dispatch->delete_flg=1;
            $dispatch->save();
            return response()->json(null, 200);
        }
        return response()->json(null,202);
    }
}
