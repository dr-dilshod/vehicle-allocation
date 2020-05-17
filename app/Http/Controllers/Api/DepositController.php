<?php

namespace App\Http\Controllers\Api;

use App\Deposit;
use App\Http\Controllers\Controller;
use App\Item;
use App\Shipper;
use DB;
use Illuminate\Http\Request;

class DepositController extends Controller
{

    public function index(){

    }

    public function filter(Request $request)
    {
        $shipper = $request->get('shipper');
        $year = $request->get('year');
        $month = $request->get('month');
        $day = $request->get('day');

        $query = Deposit::where('shipper_id', $shipper)
            ->where('delete_flg', 0);
        if (!empty($year)){
            $query->whereYear('deposit_day', $year);
        }
        if (!empty($month)){
            $query->whereMonth('deposit_day', $month);
        }
        if (!empty($day)){
            $query->whereDay('deposit_day', $day);
        }
        $query->orderBy('deposit_day', 'desc');
        $deposits = $query->get();
        $deposit = [];

        if (count($deposits) > 0){
            for ($i=1; $i<count($deposits); $i++){
                $deposits[0]->deposit_amount += $deposits[$i]->deposit_amount;
                $deposits[0]->other += $deposits[$i]->other;
                $deposits[0]->fee += $deposits[$i]->fee;
                $deposits[0]->offset += $deposits[$i]->offset;
            }
            $deposits[0]->deposit_day = date('Y-m-d', strtotime($deposits[0]->deposit_day));
            $deposit = $deposits[0];
        }
        $nextDate = date('Y-m-d', strtotime($year.'-'.$month.'-'.$day.' +1 day'));

        $total = Deposit::where('shipper_id', $shipper)
            ->whereDate('deposit_day', '<', $nextDate)
            ->where('delete_flg', 0)
            ->sum('deposit_amount');

        $billing = Item::where('shipper_id', $shipper)
            ->where('delete_flg',0)
            ->whereDate('item_completion_date', '< ', $nextDate)
            ->sum('item_price');

        $totalAll = Deposit::where('shipper_id', $shipper)
            ->where('delete_flg', 0)
            ->sum(DB::raw('IFNULL(deposit_amount,0)+IFNULL(other,0)+IFNULL(fee,0)'));

        $billingAll = Item::where('shipper_id', $shipper)
            ->where('delete_flg',0)
            ->sum('item_price');

        return [
            'unique' => count($deposits) == 1,
            'deposit' => $deposit,
            'total' => $total,
            'invoice' => $billing - $total,
        ];
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
        $request->validate(Deposit::validationRules);
        $data = $request->all();
        if (empty($data['other'])){
            $data['other'] = 0;
        }
        if (empty($data['fee'])){
            $data['fee'] = 0;
        }
        if (empty($data['offset'])){
            $data['offset'] = 0;
        }
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
        $deposit->update($request->all());

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
