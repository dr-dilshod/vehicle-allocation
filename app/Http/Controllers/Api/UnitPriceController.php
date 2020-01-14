<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\UnitPrice;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class UnitPriceController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $unitPrices = UnitPrice::with('shipper')->with('item')->with('driver');
        return $unitPrices->where('delete_flg', 0)->paginate(25);
    }

    public function show(Request $request, $id)
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
        $validator = validator()->make($request->json()->all(), UnitPrice::$createValidationRules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
        $unique = UnitPrice::query()->where([
            'shipper_id' => $request->json('shipper_id'),
            'item_id' => $request->json('item_id'),
            'driver_id' => $request->json('driver_id')
        ])->count();
        if ($unique >= 1) {
            return response()->json([
                'status' => 'error',
                'message' => __('validation.unique', ['attribute' => 'Unit price'])
            ]);
        }
        $unit_price = UnitPrice::create($request->all());
        return response()->json($unit_price, 201);
    }

    public function update(Request $request, $id)
    {
        $unit_price = UnitPrice::findOrFail($id);
        $validator = validator()->make($request->json()->all(), UnitPrice::$updateValidationRules);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }
        $unit_price->update($request->json()->all());
        return response()->json($unit_price);
    }

    public function destroy($id)
    {
        $unit_price = UnitPrice::findOrFail($id);
        $unit_price->delete_flg = 1;
        $unit_price->save();
        return response()->json(null);
    }



}
