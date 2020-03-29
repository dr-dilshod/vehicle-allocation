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
        $all = $request->json()->all();
        $updatedDrivers = [];
        $addedDrivers = [];
        foreach ($all as $driver) {
            if (!isset($driver['driver_id']) || is_null($driver['driver_id'])) {
                $driver['driver_pass'] = Hash::make($driver['driver_pass']);
                array_push($addedDrivers, $driver);
            } else {
                array_push($updatedDrivers, $driver);
            }
        }

        $save = false;
        $update = false;

        if (count($updatedDrivers) > 0) {
            $updateRules = Driver::validationRules; // fix update rules

            $this->validate($request, $updateRules);
            $updRules = [];
            foreach ($updatedDrivers as $key => $val) {
                array_push($updRules, [
                    'updateDrivers.'.$key.'.driver_no' => Rule::unique('drivers','driver_no')->ignore($val['driver_id'],'driver_id'),
                ]);
            }
            $this->validate($request, $updRules);
            $update = true;
        }

        if (count($addedDrivers) > 0) {
            $addedRules = Driver::validationRules;
            $addedRules['addedDrivers.*.driver_no'] = 'required|max:4|unique:drivers';
            $this->validate($request, $addedRules);
            $save = true;
        }

        if ($save) {
            Driver::query()->insert($addedDrivers);
        }

        if ($update) {
            foreach ($updatedDrivers as $driver) {
                Driver::query()->where('driver_id', $driver['driver_id'])->update($driver);
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
