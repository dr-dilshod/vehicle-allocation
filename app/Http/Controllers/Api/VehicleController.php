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
            'vehicle_no' => ['unique:vehicles,vehicle_no,NULL, null,delete_flg,0'],
        ]);
        $data = $request->validate(Vehicle::validationRules);
        $vehicle = Vehicle::create($data);

        return response()->json($vehicle, 201);
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'vehicle_no' => Rule::unique('vehicles','vehicle_no')->where('delete_flg', 0)->ignore($id,'vehicle_id')
        ]);
        $vehicle = Vehicle::findOrFail($id);
        $data = $request->validate(Vehicle::validationRules);
        $vehicle->update($data);

        return response()->json($vehicle, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete_flg=1;
        $vehicle->save();
        return response()->json(null, 204);
    }
}
