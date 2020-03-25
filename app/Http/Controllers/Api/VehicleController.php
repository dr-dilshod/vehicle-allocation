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
        $request->validate([
            '*.vehicle_no' => ['unique:vehicles,vehicle_no,NULL, null,delete_flg,0'],
        ]);
//        dd($request->all());
//        exit;
        $this->validate($request,Vehicle::validationRules);
        $vehicles = $request->all();
        foreach ($vehicles as $vehicle){
            if($vehicle['offset'] == null) $vehicle['offset'] = 0;
            Vehicle::create($vehicle);
        }
        return response()->json($vehicles, 201);
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
