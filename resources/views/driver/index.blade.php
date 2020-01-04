@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="padding-bottom: 100px;">
            <div class="col-md-2">
                <button class="btn btn-lg btn-warning btn-block">{{__("driver.back")}}</button>
            </div>
            <div class="col-md-2">
                <h4 class="text-danger m-2">{{__("driver.editing")}}</h4>
            </div>
            <div class="col-md-4">
                <h2 class="m-2" style="text-align: center" >{{__("driver.title")}}</h2>
            </div>
            <div class="col-md-2">
                <a href="{{ url('/driver/create') }}" class="btn btn-lg btn-danger btn-block">{{__("driver.registration")}}</a>
            </div>
            <div class="col-md-2">
                <button class="btn btn-lg btn-danger btn-block">{{__("driver.edit")}}</button>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Driver name</th>
                            <th>Mobile phone</th>
                            <th>Vehicle No</th>
                            <th>Max loading</th>
                            <th>Display</th>
                            <th>Admin</th>
                            <th>Remarks</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($driver as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->driver_name }}</td>
                                <td>{{ $item->driver_mobile_number }}</td>
                                <td>{{ $item->car_no1." ".$item->car_no2." ".$item->car_no3 }}</td>
                                <td>{{ $item->maximum_Loading }}</td>
                                <td> <input type="checkbox" checked> </td>
                                <td> <input type="checkbox" checked> </td>
                                <td>{{ $item->driver_remark }}</td>
                                <td>
                                    <a href="{{ url('/driver/' . $item->id) }}" title="View Driver"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>
                                    <a href="{{ url('/driver/' . $item->id . '/edit') }}" title="Edit Driver"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                                    <form method="POST" action="{{ url('/driver' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">
                                        {{ method_field('DELETE') }}
                                        {{ csrf_field() }}
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Driver" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"> {!! $driver->appends(['search' => Request::get('search')])->render() !!} </div>
                </div>
            </div>
        </div>
    </div>
@endsection
