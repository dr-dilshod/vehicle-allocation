<?php

namespace App\Http\Controllers\Api;

use App\Deposit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function report(Request $request){
        $shipper = $request->get('shipper');
        $year = $request->get('year');
        $month = $request->get('month');
        $day = $request->get('day');
    }

    public function index(Request $request)
    {
        $deposits = Deposit::where('delete_flg',0)->latest()->paginate(25);
        return $deposits;
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
        $data = $request->validate(Deposit::validationRules);
        $deposit = Deposit::create($data);

        return response()->json($deposit, 201);
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
        $deposit = Deposit::findOrFail($id);

        return $deposit;
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
        $data = $request->validate(Deposit::validationRules);
        $deposit = Deposit::findOrFail($id);
        $deposit->update($data);

        return response()->json($deposit, 200);
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
        $deposit = Deposit::findOrFail($id);
        $deposit->delete_flg = 1;
        $deposit->save();

        return response()->json(null, 204);
    }

}
