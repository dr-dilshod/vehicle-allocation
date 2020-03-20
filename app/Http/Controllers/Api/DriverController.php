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
            'driver_no' => ['unique:drivers,driver_no,NULL, null,delete_flg,0'],
        ]);
        $validated_driver = $request->validate(Driver::validationRules);
        //$validated_driver['driver_pass'] = Hash::make($validated_driver['driver_pass']);
        $driver = Driver::create($request->all());
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
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $drivers = $request->toArray();
        $driver_list = [];
        foreach ($drivers as $driver) {
            $id = $driver['driver_id'];
            //$driver->validate([
            //    'driver_no' => Rule::unique('drivers', 'driver_no')
            //        ->where('delete_flg', 0)
            //        ->ignore($id, 'driver_id')
            //]);
            //$driver = $driver->validate(Driver::validationRules);
            $db_driver = Driver::findOrFail($id);
            if (strcmp($db_driver['driver_pass'], $driver['driver_pass']) !== 0) {
                $driver['driver_pass'] = Hash::make($driver['driver_pass']);
            }
            $db_driver->update($driver);
            //$driver_list->push($db_driver);
        }
        return response()->json($driver_list, 200);
    }

    /**
     * Remove the specified resources in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $drivers = $request->toArray();
        $driver_list = [];
        foreach ($drivers as $driver) {
            $driver = Driver::findOrFail($driver['driver_id']);
            $removed_drivers = Driver::whereRaw('delete_flg <> 0 AND driver_no="' . $driver->driver_no . '"')->get();
            foreach ($removed_drivers as $removed_driver) {
                $removed_driver->delete_flg++;
                $removed_driver->save();
            }
            $driver->delete_flg++;
            $driver->save();
            //$driver_list->push($driver);
        }
        return response()->json($driver_list, 204);
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
