<?php

namespace App\Http\Controllers\Api;

use App\Driver;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Invoice;
use App\Item;
use App\Shipper;
use App\UnitPrice;
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
        $this->createInvoice($item);
        return response()->json($item);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function createInvoice(Item $item)
    {
        $down_invoice = $item->down_invoice;
        if ($down_invoice) {
            $item_id = $item->item_id;
            $shipper_id = $item->shipper_id;
            $vehicle_id = $item->vehicle_id;
            $invoice = Invoice::firstOrCreate(['item_id'=>$item_id,
                'shipper_id'=>$shipper_id,
                'vehicle_id'=>$vehicle_id,
                'billing_recording_date'=>date('Y-m-d')]);
            return response()->json($invoice);
        }
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
        $this->createInvoice($item);
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
        $item = Item::findOrFail($id);
        $item->delete_flg=1;
        $item->save();
        return response()->json(null, 204);
    }

    /**
     * Change the status of an item to incomplete
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function toIncomplete(Request $request)
    {
        $id = $request->query('id') ?: '';
        $item = Item::findOrFail($id);
        $item->status=0;
        $item->item_completion_date=null;
        $item->save();
        return response()->json(null, 204);
    }

    /**
     * Change the status of an item to complete
     * and set today as the completion date
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function setTodayAsCompletion(Request $request)
    {
        $id = $request->query('id') ?: '';
        $item = Item::findOrFail($id);
        $item->status=1;
        $item->item_completion_date=date("Y-m-d");
        $item->save();
        return response()->json(null, 204);
    }

    /**
     * set the date of departure to the date of completion of transportation
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function setDeptDateAsCompletion(Request $request)
    {
        $id = $request->query('id') ?: '';
        $item = Item::findOrFail($id);
        $item->status=1;
        $item->item_completion_date=$item['stack_date'];
        $item->save();
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
        $stack_date = $request->query('stack_date') ?: '';
        $shipper_name = $request->query('shipper_name') ?: '';
        $status = $request->query('status');
        $stack_point = $request->query('stack_point') ?: '';
        $down_point = $request->query('down_point') ?: '';
        $vehicle_no3 = $request->query('vehicle_no3') ?: '';
        $itemTable = Item::select()->where('delete_flg', 0);
        if (!empty($shipper_name))
            $itemTable -> where('shipper_name', $shipper_name);

        if (!empty($vehicle_no3))
            $itemTable -> where('vehicle_no3', $vehicle_no3);

        if ($status !== null)
            $itemTable -> where('status', $status);

        if (!empty($stack_date))
            $itemTable -> whereDate('stack_date', $stack_date);

        if (!empty($stack_point))
            $itemTable -> where('stack_point','LIKE', '%'.$stack_point.'%');

        if (!empty($down_point))
            $itemTable -> where('down_point', 'LIKE', '%'.$down_point.'%');

        return response()->json($itemTable->get());
    }

    /**
     * Get vehicle number list for dropdown select
     * @param Request $request
     * @return string
     */
    public function getVehicleNumbers(Request $request)
    {
        $vehicleNumbers = Item::select(['vehicle_no3'])
            ->where('delete_flg',0)
            ->orderBy('vehicle_no3','asc')
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
        $itemsShipper = Item::select(['shipper_name'])
            ->where('delete_flg',"=", 0)
            ->orderBy('shipper_name','asc')
            ->distinct()
            ->get();
        return response()->json($itemsShipper);
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDrivers(Request $request)
    {
        $drivers = Driver::select(['driver_id', 'driver_name', 'vehicle_no3'])
            ->where('delete_flg',0)
            ->where('search_flg',1)
            ->distinct()
            ->get();
        return response()->json($drivers);
    }
    /**
     * Get companies list for dropdown select
     * @param Request $request
     * @return string
     */
    public function getVehicles(Request $request)
    {
        $vehicles = Vehicle::distinct()
            ->select(['vehicle_id', 'vehicle_no', 'company_name'])
            ->where('delete_flg',0)
            ->get();
        return response()->json($vehicles);
    }

    /**
     * Get the price of one unit for auto-calculation
     * @param Request $request
     * @return string
     */
    public function getUnitPrice(Request $request)
    {
        $shipper_id = $request->query('shipper_id') ?: '';
        $vehicle_model = $request->query('vehicle_model') ?: '';
        $stack_point = $request->query('stack_point') ?: '';
        $down_point = $request->query('down_point') ?: '';

        $price = UnitPrice::select(['price'])
            ->where('delete_flg',0)
            ->where('shipper_id',$shipper_id)
            ->where('car_type', $vehicle_model)
            ->where('stack_point', $stack_point)
            ->where('down_point', $down_point)
            ->first();
        return response()->json($price);
    }
}
