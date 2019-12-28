<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Driver;
use Illuminate\Http\Request;

class DriversController extends Controller
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
            $drivers = Driver::where('driver_pass', 'LIKE', "%$keyword%")
                ->orWhere('driver_name', 'LIKE', "%$keyword%")
                ->orWhere('driver_mobile_number', 'LIKE', "%$keyword%")
                ->orWhere('maximum_Loading', 'LIKE', "%$keyword%")
                ->orWhere('search_flg', 'LIKE', "%$keyword%")
                ->orWhere('admin_flg', 'LIKE', "%$keyword%")
                ->orWhere('car_no1', 'LIKE', "%$keyword%")
                ->orWhere('car_no2', 'LIKE', "%$keyword%")
                ->orWhere('car_no3', 'LIKE', "%$keyword%")
                ->orWhere('car_type', 'LIKE', "%$keyword%")
                ->orWhere('driver_remark', 'LIKE', "%$keyword%")
                ->orWhere('delete_flg', 'LIKE', "%$keyword%")
                ->orWhere('create_id', 'LIKE', "%$keyword%")
                ->orWhere('created_at', 'LIKE', "%$keyword%")
                ->orWhere('update_id', 'LIKE', "%$keyword%")
                ->orWhere('updated_at', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $drivers = Driver::latest()->paginate($perPage);
        }

        return view('drivers.index', compact('drivers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('drivers.create');
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
			'driver_pass' => 'required|max:15',
			'driver_name' => 'required|max:60',
			'driver_mobile_number' => 'max:13',
			'maximum_Loading' => 'max:5',
			'search_flg' => 'max:1',
			'admin_flg' => 'max:1',
			'car_no1' => 'max:3',
			'car_no2' => 'max:2',
			'car_no3' => 'max:4',
			'car_type' => 'max:10',
			'driver_remark' => 'max:255'
		]);
        $requestData = $request->all();
        
        Driver::create($requestData);

        return redirect('drivers')->with('flash_message', 'Driver added!');
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
        $driver = Driver::findOrFail($id);

        return view('drivers.show', compact('driver'));
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
        $driver = Driver::findOrFail($id);

        return view('drivers.edit', compact('driver'));
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
			'driver_pass' => 'required|max:15',
			'driver_name' => 'required|max:60',
			'driver_mobile_number' => 'max:13',
			'maximum_Loading' => 'max:5',
			'search_flg' => 'max:1',
			'admin_flg' => 'max:1',
			'car_no1' => 'max:3',
			'car_no2' => 'max:2',
			'car_no3' => 'max:4',
			'car_type' => 'max:10',
			'driver_remark' => 'max:255'
		]);
        $requestData = $request->all();
        
        $driver = Driver::findOrFail($id);
        $driver->update($requestData);

        return redirect('drivers')->with('flash_message', 'Driver updated!');
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
        Driver::destroy($id);

        return redirect('drivers')->with('flash_message', 'Driver deleted!');
    }
}
