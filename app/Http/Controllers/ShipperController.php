<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Shipper;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $shipper = Shipper::where('shipper_no', 'LIKE', "%$keyword%")
                ->orWhere('shipper_name1', 'LIKE', "%$keyword%")
                ->orWhere('shipper_name2', 'LIKE', "%$keyword%")
                ->orWhere('shipper_kana_name1', 'LIKE', "%$keyword%")
                ->orWhere('shipper_kana_name2', 'LIKE', "%$keyword%")
                ->orWhere('shipper_company_abbreviation', 'LIKE', "%$keyword%")
                ->orWhere('postal_code', 'LIKE', "%$keyword%")
                ->orWhere('address1', 'LIKE', "%$keyword%")
                ->orWhere('address2', 'LIKE', "%$keyword%")
                ->orWhere('phone_number', 'LIKE', "%$keyword%")
                ->orWhere('fax_number', 'LIKE', "%$keyword%")
                ->orWhere('closing_date', 'LIKE', "%$keyword%")
                ->orWhere('delete_flg', 'LIKE', "%$keyword%")
                ->orWhere('create_id', 'LIKE', "%$keyword%")
                ->orWhere('created_at', 'LIKE', "%$keyword%")
                ->orWhere('update_id', 'LIKE', "%$keyword%")
                ->orWhere('updated_at', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $shipper = Shipper::latest()->paginate($perPage);
        }

        return view('shipper.index', compact('shipper'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('shipper.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
			'shipper_no' => 'required|max:4',
			'shipper_name1' => 'max:60',
			'shipper_name2' => 'max:60',
			'shipper_kana_name1' => 'max:60',
			'shipper_kana_name2' => 'max:60',
			'shipper_company_abbreviation' => 'max:60',
			'postal_code' => 'max:8',
			'address1' => 'max:120',
			'address2' => 'max:120',
			'phone_number' => 'max:12',
			'fax_number' => 'max:12'
		]);
        $requestData = $request->all();
        
        Shipper::create($requestData);

        return redirect('shipper')->with('flash_message', 'Shipper added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $shipper = Shipper::findOrFail($id);

        return view('shipper.show', compact('shipper'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $shipper = Shipper::findOrFail($id);

        return view('shipper.edit', compact('shipper'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
			'shipper_no' => 'required|max:4',
			'shipper_name1' => 'max:60',
			'shipper_name2' => 'max:60',
			'shipper_kana_name1' => 'max:60',
			'shipper_kana_name2' => 'max:60',
			'shipper_company_abbreviation' => 'max:60',
			'postal_code' => 'max:8',
			'address1' => 'max:120',
			'address2' => 'max:120',
			'phone_number' => 'max:12',
			'fax_number' => 'max:12'
		]);
        $requestData = $request->all();
        
        $shipper = Shipper::findOrFail($id);
        $shipper->update($requestData);

        return redirect('shipper')->with('flash_message', 'Shipper updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        Shipper::destroy($id);

        return redirect('shipper')->with('flash_message', 'Shipper deleted!');
    }
}
