<?php

namespace App\Http\Controllers\Api;

use App\Driver;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Item;
use App\Shipper;
use App\Vehicle;
use Illuminate\Http\Request;

/**
 * Class ItemController
 * @package App\Http\Controllers\Api
 * @author Dilshod K
 */
class ItemController extends Controller
{
    /**
     * @var Item
     */
    protected $item;

    /**
     * VehicleController constructor.
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $item = Item::latest()->paginate(25);

        return $item;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $item = Item::create($request->all());

        return response()->json($item);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Item::findOrFail($id);

        return $item;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $item = Item::findOrFail($id);
        $item->update($request->all());

        return response()->json($item, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::destroy($id);

        return response()->json(null, 204);
    }

    /**
     * returns the list of item based on the query on the item list view
     *
     * @param Request $request
     * @return mixed
     */
    public function getItemList(Request $request)
    {
        //$shipper_id = $request->query('shipper_id') ?: '';
        //$items = $this->item->where([
        //    'shipper_id'=>$shipper_id,
        //    'delete_flg'=>0
        //])->get();

        $shipper_id = $request->query('shipper_id') ?: '';
        $vehicle_no = $request->query('vehicle_no') ?: '';
        $status = $request->query('status') ?: '';
        $stack_date = $request->query('stack_date') ?: '';
        $stack_point = $request->query('stack_point') ?: '';
        $matchThese = ['delete_flg' => 0];
        if (!empty($shipper_id)) {
            $matchThese = array_add($matchThese, 'shipper_id', $shipper_id);
        } else if (!empty($vehicle_no)) {
            $matchThese = array_add($matchThese, 'vehicle_no', $vehicle_no);
        } else if (!empty($status)) {
            $matchThese = array_add($matchThese, 'status', $status);
        } else if (!empty($stack_date)) {
            $matchThese = array_add($matchThese, 'stack_date', $stack_date);
        } else if (!empty($stack_point)) {
            $matchThese = array_add($matchThese, 'stack_point', $stack_point);
        }
        $itemTable = Item::where($matchThese)->get();
        return response()->json($itemTable);
    }

    /**
     * Get vehicle number list for dropdown select
     * @param Request $request
     * @return string
     */
    public function getVehicleNumbers(Request $request)
    {
        $vehicleNumbers = Item::select(['vehicle_no'])
            ->where('delete_flg',0)
            ->orderBy('vehicle_no','asc')
            ->distinct()
            ->get();
        return response()->json($vehicleNumbers);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getItemShippers(Request $request)
    {
        $itemsShipper = Item::leftJoin('shippers', 'items.shipper_id', '=', 'shippers.shipper_id')
            ->where('items.delete_flg',"=", 0)
            ->orderBy('shippers.shipper_name1','asc')
            ->distinct()
            ->select(['items.shipper_id','shippers.shipper_name1','shippers.shipper_name2'])
            ->get();
        return response()->json($itemsShipper);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShippers(Request $request)
    {
        $shippers = Shipper::select(['shipper_id', 'shipper_name1'])
            ->where('delete_flg',0)
            ->get();
        return response()->json($shippers);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDrivers(Request $request)
    {
        $drivers = Driver::select(['driver_id', 'driver_name'])
            ->where('delete_flg',0)
            ->get();
        return response()->json($drivers);
    }
}
