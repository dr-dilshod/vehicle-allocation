<?php


namespace App\Http\Controllers\Api;


use App\Driver;
use App\Http\Controllers\Controller;
use App\Shipper;
use App\UnitPrice;
use Illuminate\Http\Request;

class UnitPriceController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $shipper_id = $request->get('shipper_id');
        $unitPrices = UnitPrice::with('shipper');
        if ($shipper_id) {
            $unitPrices->where('shipper_id', '=', $shipper_id);
        }
        return $unitPrices->where('delete_flg', 0)->get();
    }

    public function show($id)
    {
        $unit_price = UnitPrice::with('shipper')
            ->with('item')
            ->with('driver')
            ->where('price_id', '=', $id)->first();
        return response()->json($unit_price);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate(UnitPrice::$createValidationRules);
        $all = $request->all();
        $shipper = Shipper::find($request->input('shipper_id'));
        $all = array_merge($all, ['shipper_no' => $shipper->shipper_no]);
        $unit_price = UnitPrice::create($all);
        return response()->json($unit_price, 201);
    }

    public function update(Request $request, $id)
    {
        $unit_price = UnitPrice::findOrFail($id);
        $data = $request->validate(UnitPrice::$updateValidationRules);
        $all = $request->json()->all();
        $all = array_merge($all, ['update_id' => \Auth::id()]);
        $unit_price->update($all);
        return response()->json($unit_price);
    }

    public function destroy($id)
    {
        $unit_price = UnitPrice::findOrFail($id);
        $unit_price->delete_flg = 1;
        $unit_price->save();
        return response()->json(null);
    }

    public function getDistrictShipperNames() {
        $shippers = Shipper::select(['shipper_id', 'shipper_name1', 'shipper_name2'])
            ->where('delete_flg', 0)
            ->distinct()
            ->orderBy('shipper_name1', 'ASC')
            ->get();

        return response()->json($shippers);
    }

    public function getVehicleTypes()
    {
        $vehicleTypes = Driver::query()->select(['vehicle_type'])
            ->where('vehicle_type', '!=', null)
            ->where('delete_flg', 0)
            ->distinct()
            ->get();
        return response()->json($vehicleTypes);
    }

}
