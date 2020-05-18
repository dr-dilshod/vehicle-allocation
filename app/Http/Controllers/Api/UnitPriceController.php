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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $all = $request->json()->all();
        $save = false;
        $update = false;

        $updated = [];
        $added = [];
        foreach ($all as $price) {
            if (!isset($price['price_id']) || is_null($price['price_id'])) {
                array_push($added, $price);
            } else {
                array_push($updated, $price);
            }
        }

        if (count($updated) > 0) {
            $this->validate($request, UnitPrice::$updateValidationRules);
            $update = true;
        }

        if (count($added) > 0) {
            $this->validate($request, UnitPrice::$createValidationRules);
            $save = true;
        }

        if ($save) {
            $added = array_map(function($el) {
                $shipper = Shipper::find($el['shipperId']);
                $el['shipper_no'] = $shipper->shipper_no;
                $el['shipper_id'] = $el['shipperId'];
                unset($el['shipperId']);
                return $el;

            }, $added);
            UnitPrice::query()->insert($added);
        }

        if ($update) {
            $updated = array_map(function($el) {
                $shipper = Shipper::find($el['shipperId']);
                $el['shipper_no'] = $shipper->shipper_no;
                $el['shipper_id'] = $el['shipperId'];
                unset($el['shipperId']);
                return $el;

            }, $updated);
            foreach ($updated as $price) {
                UnitPrice::query()->where('price_id', $price['price_id'])->update($price);
            }
        }

        return response()->json([], 201);
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

    public function getDistrictShipperNames()
    {
        $shipperIDs = UnitPrice::query()->select('shipper_id')->get()->all();
        $shipperIDs = collect($shipperIDs)->map(function ($el) {
           return $el['shipper_id'];
        });
        $shippers = Shipper::query()->select(['shipper_id', 'shipper_name1', 'shipper_name2'])
            ->whereIn('shipper_id', $shipperIDs)
            ->where('delete_flg', 0)
            ->distinct()
            ->orderBy('shipper_name1', 'ASC')
            ->get();

        return response()->json($shippers);
    }

    public function getAllShipperNames()
    {
        $shippers = Shipper::query()->select(['shipper_id', 'shipper_name1', 'shipper_name2'])
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * register single unit price
     */
    public function register(Request $request)
    {
        //$data = $request->validate(UnitPrice::$validationRules);
        $price = UnitPrice::create($request->all());
        return response()->json($price);
    }
}
