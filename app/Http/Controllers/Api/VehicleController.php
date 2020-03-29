<?php

namespace App\Http\Controllers\Api;

use App\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company_name = $request->query('company_name') ?: '';
        if($company_name !== '')
            $vehicles = Vehicle::where([
                'company_name'=>$company_name,
                'delete_flg'=>0
            ])->orderBy('vehicle_no')->get();
        else
            $vehicles = Vehicle::where([
                'delete_flg'=>0
            ])->orderBy('vehicle_no')->get();
        return response()->json($vehicles,200);
    }

    /**
     *
     * @param Request $request
     * @return mixed
     */
    public function getCompanies(Request $request)
    {
        $companies = Vehicle::select('company_name')
            ->where('delete_flg',0)
            ->distinct()
            ->get();
        return response()->json($companies, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $all = $request->json()->all();
        $updatedVehicles = [];
        $addedVehicles = [];
        foreach ($all as $vehicle) {
            if (!isset($vehicle['vehicle_id']) || is_null($vehicle['vehicle_id'])) {
                array_push($addedVehicles, $vehicle);
            } else {
                array_push($updatedVehicles, $vehicle);
            }
        }

        $save = false;
        $update = false;

        if (count($updatedVehicles) > 0) {
            $updateRules = Vehicle::updateRules;

            $this->validate($request, $updateRules);
            $updRules = [];
            foreach ($updatedVehicles as $key => $val) {
                array_push($updRules, [
                    'updatedVehicles.'.$key.'.vehicle_no' => Rule::unique('vehicles','vehicle_no')->ignore($val['vehicle_id'],'vehicle_id'),
                ]);
            }
            $this->validate($request, $updRules);
            $update = true;
        }

        if (count($addedVehicles) > 0) {
            $addedRules = vehicle::validationRules;
            $addedRules['addedVehicles.*.vehicle_no'] = 'required|max:4|unique:vehicles';
            $this->validate($request, $addedRules);
            $save = true;
        }


        if ($save) {
            Vehicle::query()->insert($addedVehicles);
        }

        if ($update) {
            foreach ($updatedVehicles as $vehicle) {
                Vehicle::query()->where('vehicle_id', $vehicle['vehicle_id'])->update($vehicle);
            }
        }

        return response()->json([], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return $vehicle;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,Vehicle::validationRules);
        $vehicles = $request->all();
        foreach ($vehicles as $vehicle){
            if($vehicle['offset'] == null) $vehicle['offset'] = 0;
            $db_vehicle = Vehicle::findOrFail($vehicle['vehicle_id']);
            $db_vehicle->update($vehicle);
        }
        return response()->json(null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $vehicles = $request->all();
        foreach ($vehicles as $vehicle){
            $vehicle = Vehicle::findOrFail($vehicle['vehicle_id']);
            $vehicle->delete_flg++;
            $vehicle->save();
        }
        return response()->json(null, 204);
    }
}
