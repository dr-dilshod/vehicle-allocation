<?php

namespace App\Http\Controllers\Api;

use App\Dispatch;
use App\Driver;
use App\Item;
use App\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DispatchController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        setlocale(LC_ALL, 'ja_JA');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = [];
        $firstDate = $request->get('date');
//        $firstDate = date('Y-m-d',strtotime($date."+1 day"));
//        if(date('w',strtotime($firstDate)) == 0) // if Sunday
//            $firstDate = date('Y-m-d',strtotime($firstDate." +1 day"));
        $secondDate = date('Y/m/d',strtotime($firstDate." +1 day"));
        if(date('w',strtotime($secondDate)) == 0) // if Sunday
            $secondDate = date('Y/m/d',strtotime($secondDate." +1 day"));
        $firstListItems = \DB::table('items')
            ->select(['items.item_id','items.driver_id','items.shipper_id','items.down_date','items.down_time',
            'items.down_point','items.shipper_name','items.stack_point','items.weight','items.empty_pl','items.item_remark'])
            ->whereRaw('items.down_date = "'.$firstDate.'" AND items.delete_flg=0 AND items.dispatch_status='.Item::DISPATCH_STATUS_OUT_DISPATCH)
            ->get();
        $secondListItems = \DB::table('items')
            ->select(['items.item_id','items.driver_id','items.shipper_id','items.down_date','items.down_time',
            'items.down_point','items.shipper_name','items.stack_point','items.weight','items.empty_pl','items.item_remark'])
            ->whereRaw('items.down_date >= "'. $secondDate .'" AND items.delete_flg=0 AND items.dispatch_status='.Item::DISPATCH_STATUS_OUT_DISPATCH)
            ->get();
        $result['first_list'] = [
            'date' => $firstDate,
            'formatDate'=>strftime('%m/%d %a',strtotime($firstDate)),
            'items'=>$firstListItems
        ];
        $result['second_list'] = [
            'date'=>$secondDate,
            'formatDate'=>strftime('%m/%d %a',strtotime($secondDate)),
            'items'=>$secondListItems
        ];
        $drivers = Driver::select(['driver_id','driver_name','vehicle_no3'])
            ->where([
                'delete_flg'=>0,
                'search_flg'=>0,
            ])
            ->orderBy('vehicle_no3')
            ->get();
        $tableDriverList = [];
        $result['drivers'] = $drivers;
        $result['dispatch_drivers'] = $drivers;
        foreach($drivers as $driver){
            $morning_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->where([
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.timezone'=>Dispatch::TIMEZONE_MORNING,
                    'dispatches.delete_flg'=>0,
                    'items.delete_flg'=>0,
                ])->whereRaw('items.down_date >= "'. $firstDate .'"')
                ->get();
            $noon_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->where([
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.timezone'=>Dispatch::TIMEZONE_NOON,
                    'dispatches.delete_flg'=>0,
                    'items.delete_flg'=>0,
                ])->whereRaw('items.down_date >= "'. $firstDate .'"')
                ->get();
            $next_items = \DB::table('dispatches')
                ->leftJoin('items','dispatches.item_id','=','items.item_id')
                ->where([
                    'dispatches.driver_id'=>$driver->driver_id,
                    'dispatches.timezone'=>Dispatch::TIMEZONE_NEXT_PRODUCT,
                    'dispatches.delete_flg'=>0,
                    'items.delete_flg'=>0,
                ])->whereRaw('items.down_date >= "'. $firstDate .'"')
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
        $result['date'] = $firstDate;
        return response()->json($result);
    }

    public function firstList(Request $request){
        $result = [];
        $date = $request->get('date');
        $firstDate = date('Y/m/d',strtotime($date." +1 day"));
        if(date('w',strtotime($firstDate)) == 0) // if Sunday
            $firstDate = date('Y/m/d',strtotime($firstDate." +1 day"));
        $firstListItems = \DB::table('items')
            ->select(['items.item_id','items.driver_id','items.shipper_id','items.down_date','items.down_time',
                'items.down_point','items.shipper_name','items.stack_point','items.weight','items.empty_pl','items.item_remark'])
            ->whereRaw('items.down_date >= "'.$firstDate.'" AND items.delete_flg=0')
            ->get();
        $result['first_list'] = [
            'date' => $firstDate,
            'formatDate'=>strftime('%m/%d %a',strtotime($firstDate)),
            'items'=>$firstListItems
        ];
        return response()->json($result);
    }

    public function secondList(Request $request){
        $result = [];
        $firstDate = $request->get('date');
        $secondDate = date('Y/m/d',strtotime($firstDate." +1 day"));
        if(date('w',strtotime($secondDate)) == 0) // if Sunday
            $secondDate = date('Y/m/d',strtotime($secondDate." +1 day"));
        $secondListItems = \DB::table('items')
            ->select(['items.item_id','items.driver_id','items.shipper_id','items.down_date','items.down_time',
                'items.down_point','items.shipper_name','items.stack_point','items.weight','items.empty_pl','items.item_remark'])
            ->whereRaw('items.down_date >= "'. $secondDate .'" AND items.delete_flg=0')
            ->get();
        $result['second_list'] = [
            'date'=>$secondDate,
            'formatDate'=>strftime('%m/%d %a',strtotime($secondDate)),
            'items'=>$secondListItems
        ];
        return response()->json($result);
    }

    public function driverList(){
        $drivers = Driver::select(['driver_id','driver_name','vehicle_no3'])
            ->where([
                'delete_flg'=>0,
                'search_flg'=>0,
            ])
            ->orderBy('vehicle_no3')
            ->get();
        $tableDriverList = [];
        foreach ($drivers as $driver)
            $tableDriverList[] = $driver->driver_id;
        $result['tableDriverList'] = $tableDriverList;
        $result['drivers'] = $drivers;
        return response()->json($result);
    }

    /**
     *
     */
    public function thirdList(Request $request){
        $result = [];

        $date = $request->get('date');

        foreach (Driver::vehicleTypes as $type){
            $drivers = Driver::where([
                'vehicle_type'=>$type,
                'search_flg'=>Driver::SEARCH_FLAG_WORKING,
                'delete_flg'=>0
            ])
                ->get();
            $items = [];
            foreach ($drivers as $driver){
                $morning_items = \DB::table('dispatches')
                    ->leftJoin('items','dispatches.item_id','=','items.item_id')
                    ->where([
                        'dispatches.driver_id'=>$driver->driver_id,
                        'dispatches.timezone'=>Dispatch::TIMEZONE_MORNING,
                        'dispatches.delete_flg'=>0,
                        'items.delete_flg'=>0,
                    ])->whereRaw('items.down_date >= "'. $date . '"')
                    ->get();
                $noon_items = \DB::table('dispatches')
                    ->leftJoin('items','dispatches.item_id','=','items.item_id')
                    ->where([
                        'dispatches.driver_id'=>$driver->driver_id,
                        'dispatches.timezone'=>Dispatch::TIMEZONE_NOON,
                        'dispatches.delete_flg'=>0,
                        'items.delete_flg'=>0,
                    ])->whereRaw('items.down_date >= "'. $date . '"')
                    ->get();
                $next_items = \DB::table('dispatches')
                    ->leftJoin('items','dispatches.item_id','=','items.item_id')
                    ->where([
                        'dispatches.driver_id'=>$driver->driver_id,
                        'dispatches.timezone'=>Dispatch::TIMEZONE_NEXT_PRODUCT,
                        'dispatches.delete_flg'=>0,
                        'items.delete_flg'=>0,
                    ])->whereRaw('items.down_date >= "'. $date . '"')
                    ->get();
                $items[]=[
                    'driver_id' => $driver->driver_id,
                    'vehicle_no' => $driver->vehicle_no3,
                    'driver_name' => $driver->driver_name,
                    'morning' => $morning_items,
                    'noon' => $noon_items,
                    'nextProduct' => $next_items
                ];
            }
            $result[] = [
                'type' => $type,
                'items' => $items
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
        $added = $data['added'];
        $removed = $data['removed'];
        foreach($added as $item){
            $dispatch = Dispatch::create($item);
            if($dispatch){
                $stmt = \DB::update('UPDATE items SET dispatch_status=? WHERE item_id=?',[Item::DISPATCH_STATUS_IN_DISPATCH,$dispatch->item_id]);
            }
        }
        foreach ($removed as $item){
            $this->removeItem($item['item_id'],$item['driver_id'],$item['timezone']);
        }
        return response()->json($data, 201);
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

    /**
     * @param $item
     * @return mixed
     */
    protected function itemAlreadyExists($item){
        return Dispatch::where([
            'item_id' => $item['item_id'],
            'delete_flg' => 0
        ])->get();
    }

    /**
     * @param $item
     */
    protected function removeItem($item_id,$driver_id,$timezone){
        \DB::update('UPDATE dispatches SET delete_flg=1 WHERE item_id=? AND driver_id=? AND timezone=?',[$item_id,$driver_id,$timezone]);
    }

    public function thirdList2(Request $request)
    {
        $result = [];

        $date = $request->get('date');

        foreach (Driver::vehicleTypes as $type){
            $drivers = Driver::where([
                'vehicle_type'=>$type,
                'search_flg'=>Driver::SEARCH_FLAG_WORKING,
                'delete_flg'=>0
            ])
                ->get();
            $items = [];
            foreach ($drivers as $driver){
                $morning_items = \DB::table('dispatches')
                    ->leftJoin('items','dispatches.item_id','=','items.item_id')
                    ->where([
                        'dispatches.driver_id'=>$driver->driver_id,
                        'dispatches.timezone'=>Dispatch::TIMEZONE_MORNING,
                        'dispatches.delete_flg'=>0,
                        'items.delete_flg'=>0,
                    ])->whereRaw('items.down_date >= "'. $date . '"')
                    ->get();
                $noon_items = \DB::table('dispatches')
                    ->leftJoin('items','dispatches.item_id','=','items.item_id')
                    ->where([
                        'dispatches.driver_id'=>$driver->driver_id,
                        'dispatches.timezone'=>Dispatch::TIMEZONE_NOON,
                        'dispatches.delete_flg'=>0,
                        'items.delete_flg'=>0,
                    ])->whereRaw('items.down_date >= "'. $date . '"')
                    ->get();
                $next_items = \DB::table('dispatches')
                    ->leftJoin('items','dispatches.item_id','=','items.item_id')
                    ->where([
                        'dispatches.driver_id'=>$driver->driver_id,
                        'dispatches.timezone'=>Dispatch::TIMEZONE_NEXT_PRODUCT,
                        'dispatches.delete_flg'=>0,
                        'items.delete_flg'=>0,
                    ])->whereRaw('items.down_date >= "'. $date . '"')
                    ->get();
                $items[]=[
                    'driver_id' => $driver->driver_id,
                    'vehicle_no' => $driver->vehicle_no3,
                    'driver_name' => $driver->driver_name,
                    'morning' => $morning_items,
                    'noon' => $noon_items,
                    'nextProduct' => $next_items
                ];
            }
            $result[] = [
                'type' => $type,
                'items' => $items
            ];
        }
        return response()->json($result);
    }

    public function theList(Request $request){
        $result = [];

        $date = $request->get('date');

        foreach (Driver::vehicleTypes as $type){
            $drivers = Driver::where([
                'vehicle_type'=>$type,
                'search_flg'=>Driver::SEARCH_FLAG_WORKING,
                'delete_flg'=>0
            ])
            ->get();
            $items = [];
            foreach ($drivers as $driver){
                $morning_items = \DB::table('dispatches')
                    ->leftJoin('items','dispatches.item_id','=','items.item_id')
                    ->where([
                        'dispatches.driver_id'=>$driver->driver_id,
                        'dispatches.timezone'=>Dispatch::TIMEZONE_MORNING,
                        'dispatches.delete_flg'=>0,
                        'items.delete_flg'=>0,
                    ])
                    ->get();
                $noon_items = \DB::table('dispatches')
                    ->leftJoin('items','dispatches.item_id','=','items.item_id')
                    ->where([
                        'dispatches.driver_id'=>$driver->driver_id,
                        'dispatches.timezone'=>Dispatch::TIMEZONE_NOON,
                        'dispatches.delete_flg'=>0,
                        'items.delete_flg'=>0,
                    ])
                    ->get();
                $next_items = \DB::table('dispatches')
                    ->leftJoin('items','dispatches.item_id','=','items.item_id')
                    ->where([
                        'dispatches.driver_id'=>$driver->driver_id,
                        'dispatches.timezone'=>Dispatch::TIMEZONE_NEXT_PRODUCT,
                        'dispatches.delete_flg'=>0,
                        'items.delete_flg'=>0,
                    ])
                    ->get();
                $items[]=[
                    'driver_id' => $driver->driver_id,
                    'vehicle_no' => $driver->vehicle_no3,
                    'driver_name' => $driver->driver_name,
                    'morning' => $morning_items,
                    'noon' => $noon_items,
                    'nextProduct' => $next_items
                ];
            }
            $result[] = [
                'type' => $type,
                'items' => $items
            ];
        }
        return response()->json($result);
    }
}
