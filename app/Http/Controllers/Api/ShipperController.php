<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Shipper;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\ParameterBag;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $bill_to = $request->get('bill-to');
        $name = $request->get('name');
        $perPage = 25;

        if (!empty($bill_to) && !empty($name)) {

            $shipper = Shipper::where(function ($query) use ($name) {
                    return $query->where('shipper_name1', $name)->orWhere('shipper_name2', $name);})
                ->where([['shipper_company_abbreviation', $bill_to],['delete_flg', 0]])
                ->orderBy('shipper_no','asc')
                ->latest()->paginate($perPage);

        } else if (empty($bill_to) && !empty($name)){

            $shipper = Shipper::where(function ($query) use ($name) {
                return $query->where('shipper_name1', $name)->orWhere('shipper_name2', $name);})
                ->where('delete_flg', 0)
                ->orderBy('shipper_no','asc')
                ->latest()->paginate($perPage);

        } else if (!empty($bill_to) && empty($name)){
            $shipper = Shipper::where([['shipper_company_abbreviation', $bill_to],['delete_flg',0]])
                ->orderBy('shipper_no','asc')
                ->latest()->paginate($perPage);
        } else {
            $shipper = Shipper::where('delete_flg',0)->orderBy('shipper_no','asc')
                ->latest()->paginate($perPage);
        }

        return $shipper;
    }

    public function filter(Request $request)
    {
        $bill_to = $request->get('billTo');
        $shipper = $request->get('shipper');

        if (!empty($bill_to) && !empty($shipper)) {
            $shipper = Shipper::where([
                    ['shipper_id', $shipper],
                    ['shipper_company_abbreviation', $bill_to],
                    ['delete_flg', 0]])
                ->orderBy('shipper_no','asc')
                ->get();

        } else if (!empty($shipper) && empty($bill_to)){

            $shipper = Shipper::where([
                ['shipper_id', $shipper],
                ['delete_flg', 0]])
                ->orderBy('shipper_no','asc')
                ->get();

        } else if (!empty($bill_to) && empty($shipper)){
            $shipper = Shipper::where([
                ['shipper_company_abbreviation', $bill_to],
                ['delete_flg', 0]])
                ->orderBy('shipper_no','asc')
                ->get();
        } else {
            $shipper = Shipper::where('delete_flg',0)
                ->orderBy('shipper_no','asc')
                ->get();
        }

        return $shipper;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $all = $request->json()->all();
        $updatedShippers = [];
        $addedShippers = [];
        foreach ($all as $shipper) {
            if (!isset($shipper['shipper_id']) || is_null($shipper['shipper_id'])) {
                array_push($addedShippers, $shipper);
            } else {
                array_push($updatedShippers, $shipper);
            }
        }

        $save = false;
        $update = false;

        if (count($updatedShippers) > 0) {
            $updateRules = Shipper::updateRules;
            $validator = validator()->make($updatedShippers, Shipper::updateRules);
            if ($validator->fails()) {
                return response()->json([
                    'message' => '指定されたデータは無効です！ エラーリスト',
                    'errors' => $validator->errors()
                ], 422);
            }
            foreach ($updatedShippers as $val) {
                $shippers = Shipper::query()->where('shipper_no', '=', $val['shipper_no'])->get();
                $shipperObj = $shippers->first();
                if ($shippers->count() <= 1) {
                    if (!is_null($shipperObj) && $shipperObj->shipper_id != $val['shipper_id']) {
                        $message = __('validation.unique', ['attribute' => __('shipper.shipper_no')]);
                        return response()->json([
                            'message' => '指定されたデータは無効です！ エラーリスト',
                            'errors' => [
                                'shipper_no' => [
                                    $message
                                ]
                            ]
                        ], 422);
                    }
                }

            }

            $update = true;
        }

        if (count($addedShippers) > 0) {
            $validator = validator()->make($addedShippers, Shipper::validationRules);
            if ($validator->fails()) {
                return response()->json([
                    'message' => '指定されたデータは無効です！ エラーリスト',
                    'errors' => $validator->errors()
                ], 422);
            }
            $save = true;
        }


        if ($save) {
            Shipper::query()->insert($addedShippers);
        }

        if ($update) {
            foreach ($updatedShippers as $shipper) {
                Shipper::query()->where('shipper_id', $shipper['shipper_id'])->update($shipper);
            }
        }

        return response()->json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shipper = Shipper::findOrFail($id);

        return $shipper;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ids = $request->json('ids');
        Shipper::query()->whereIn('shipper_id', $ids)->update([
           'delete_flg' => 1
        ]);
        return response()->json(null, 204);
    }

    /**
     * Listing of the distinct shipper names.
     *
     * @return \Illuminate\Http\Response
     */
    public function distinctNames(Request $request)
    {
        $name1_query = Shipper::select('shipper_name1')
            ->where('delete_flg',0);
        $distinctNames = Shipper::select('shipper_name2')
            ->where('delete_flg',0)
            ->union($name1_query)
            ->orderBy('shipper_name2', 'asc')
            ->get();

        $result = array_map(function ($el){
            return $el['shipper_name2'];
        }, $distinctNames->toArray());

        return response()->json($result, 200);
    }

    /**
     * Listing of the distinct shipper names.
     *
     * @return \Illuminate\Http\Response
     */
    public function distinctCompanies(Request $request)
    {
        $distinctCompanies = Shipper::select('shipper_company_abbreviation')
            ->where('delete_flg',0)
            ->where('shipper_company_abbreviation','<>','')
            ->where('shipper_company_abbreviation','<>', null)
            ->distinct()
            ->orderBy('shipper_company_abbreviation', 'asc')
            ->get();

        $result = array_map(function ($el){
            return $el['shipper_company_abbreviation'];
        }, $distinctCompanies->toArray());

        return response()->json($result, 200);
    }

    public function getFullnames(Request $request)
    {
        $shippers = Shipper::select('shipper_id',
            DB::raw('concat(shipper_name1, \' \', ifnull(shipper_name2,\'\')) as fullname'))
            ->where('delete_flg',0)
            ->orderBy('fullname', 'asc')
            ->get();

        return response()->json($shippers, 200);
    }

}
