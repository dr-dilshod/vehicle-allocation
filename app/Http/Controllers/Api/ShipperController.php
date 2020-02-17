<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Shipper;
use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(Shipper::validationRules);
        $request->validate($request, [
            'shipper_no' => 'unique:shippers',
        ]);
        $shipper = Shipper::create($request->all());

        return response()->json($shipper, 201);
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
        $data = $request->validate(Shipper::validationRules);
        $shipper = Shipper::findOrFail($id);
        $request->validate([
            'shipper_no' => Rule::unique('shippers','shipper_no')->ignore($id,'shipper_id'),
        ]);
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
        $shipper = Shipper::findOrFail($id);
        $shipper->delete_flg = 1;
        $shipper->save();

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
