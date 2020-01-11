<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Shipper;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $shipper = Shipper::latest()->paginate(25);

        return $shipper;
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

        $shipper = Shipper::create($request->all());

        return response()->json($shipper, 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShippers(Request $request)
    {
        $shippers = Shippers::select('id, shipper_name1')
            ->where('delete_flg',0)
            ->distinct()
            ->get();
        return response()->json($shippers, 200);
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
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $shipper = Shipper::findOrFail($id);
        $shipper->update($request->all());

        return response()->json($shipper, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Shipper::destroy($id);

        return response()->json(null, 204);
    }
}
