<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleResource;
use App\Vehicle;
use Illuminate\Http\Request;
use Psy\Util\Json;

class VehicleController extends Controller
{
    /**
     * @var Vehicle
     */
    protected $vehicle;

    /**
     * VehicleController constructor.
     * @param Vehicle $vehicle
     */
    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function vehicleTable(Request $request)
    {
        $company_name = $request->query('company_name') ?: '';
        $vehicles = $this->vehicle->where([
            'company_name'=>$company_name,
            'delete_flg'=>0
        ])->orderBy('vehicle_no')->get();
        return VehicleResource::collection($vehicles);
    }

    /**
     * Get companies list for dropdown select
     * @param Request $request
     * @return string
     */
    public function companies(Request $request)
    {
        $companies = Vehicle::select('company_name')
            ->where('delete_flg',0)
            ->distinct()
            ->get();
        return Json::encode($companies);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vehicle.index');
    }

}
