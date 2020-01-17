<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Item;
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
        $shipper_id = $request->query('shipper_id') ?: '';
        $items = $this->item->where([
            'shipper_id'=>$shipper_id,
            'delete_flg'=>0
        ])->get();
        return response()->json($items);
    }

    /**
     * Get vehicle number list for dropdown select
     * @param Request $request
     * @return string
     */
    public function getVehicleNumbers(Request $request)
    {
        $vehicle = Vehicle::select(['vehicle_id', 'vehicle_no'])
            ->where('delete_flg',0)
            ->get();
        return response()->json($vehicle);
    }
}
