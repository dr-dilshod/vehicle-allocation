<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Driver;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $drivers = Driver::where([
            'delete_flg'=>0
        ])->orderBy('driver_name')->get();
        return response()->json($drivers,200);
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
        $request->validate([
            'driver_no' => ['unique:drivers,driver_no,NULL,NULL,delete_flg,0'],
        ]);
        $data = $request->validate(Driver::validationRules);
        $data['driver_pass'] = Hash::make($data['driver_pass']);
        $driver = Driver::create($data);
        return response()->json($driver, 201);

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
        $driver = Driver::findOrFail($id);
        return $driver;
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
        $request->validate([
            'driver_no' => Rule::unique('drivers','driver_no')->ignore($id,'driver_id'),
        ]);
        $data = $request->validate(Driver::validationRules);
        $driver = Driver::findOrFail($id);
        if(strcmp($driver['driver_pass'], $request['driver_pass']) !== 0){
            $request['driver_pass'] = Hash::make($request['driver_pass']);
        }
        $driver->update($request->all());
        return response()->json($driver, 200);
    }

    /*
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $removed_drivers = Driver::whereRaw('delete_flg <> 0 AND driver_no="'.$driver->driver_no.'"')->get();
        foreach ($removed_drivers as $removed_driver){
            $removed_driver->delete_flg++;
            $removed_driver->save();
        }
        $driver->delete_flg++;
        $driver->save();
        return response()->json(null, 204);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVehicleNumbers(){
        $vehicles = Driver::select(['vehicle_no3'])
            ->where('delete_flg',0)
            ->where('vehicle_no3', '!=', null)
            ->distinct()
            ->orderBy('vehicle_no3')
            ->get();
        return response()->json($vehicles);
    }
}
