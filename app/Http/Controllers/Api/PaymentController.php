<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;
use App\Payment;
use App\Shipper;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $result = Payment::where([
            'payment_amount'=>'2000-01-01',
            'delete_flg'=>0
        ])->orderBy('payment_day')->paginate(25);
        return response()->json($result);
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShippers(Request $request)
    {
        $shippers = Shipper::select(['shipper_id', 'shipper_name1', 'shipper_name2'])
            ->where('delete_flg',0)
            ->distinct()
            ->get();
        return response()->json($shippers);
    }

    public function filter(Request $request)
    {
        $shipper = $request->get('shipper');
        $year = $request->get('year');
        $month = $request->get('month');
        $day = $request->get('day');

        $query = Payment::where('shipper_id', $shipper)
            ->where('delete_flg', 0)
            ->whereYear('payment_day', $year)
            ->whereMonth('payment_day', $month)
            ->whereDay('payment_day', $day)
            ->orderBy('payment_day', 'desc');

        $payments = $query->get();
        $payment = [];

        if (count($payments) > 0){
            for ($i=1; $i<count($payments); $i++){
                $payments[0]->payment_amount += $payments[$i]->payment_amount;
                $payments[0]->other += $payments[$i]->other;
                $payments[0]->fee += $payments[$i]->fee;
            }
            $payments[0]->payment_day = date('Y-m-d', strtotime($payments[0]->payment_day));
            $payment = $payments[0];
        }
        $nextDate = date('Y-m-d', strtotime($year.'-'.$month.'-'.$day.' +1 day'));

        $total = Payment::where('shipper_id', $shipper)
            ->whereDate('payment_day', '<', $nextDate)
            ->where('delete_flg', 0)
            ->sum('payment_amount');

        $invoice = Item::where('shipper_id', $shipper)
            ->where('delete_flg',0)
            ->whereDate('item_completion_date', '< ', $nextDate)
            ->sum('item_price');

        return [
            'unique' => count($payments) == 1,
            'payment' => $payment,
            'total' => $total,
            'invoice' => $invoice - $total,
            'offset' => 0,
        ];
    }

    public function store(Request $request)
    {
        $request->validate(Payment::validationRules);
        $data = $request->all();
        if (empty($data['other'])){
            $data['other'] = 0;
        }
        if (empty($data['fee'])){
            $data['fee'] = 0;
        }
        $payment = Payment::create($data);
        return response()->json($payment, 201);
    }

    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return $payment;
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate(Payment::validationRules);
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());

        return response()->json($payment, 200);
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete_flg = 1;
        $payment->save();

        return response()->json(null, 204);
    }

}
