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
        ])->orderBy('driver_name')->paginate(25);
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
        $data = $request->validate(Driver::validationRules);
//        $request->validate($request, [
//            'driver_name' => 'unique:driver_name',
//        ]);
        $request['driver_pass'] = Hash::make($request['driver_pass']);
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
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate(Driver::validationRules);
        $driver = Driver::findOrFail($id);
        $request->validate([
            'driver_name' => Rule::unique('drivers','Driver_name')->ignore($id,'driver_id'),
        ]);
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
        $driver->delete_flg=1;
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
