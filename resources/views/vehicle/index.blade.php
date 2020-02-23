@extends('layouts.app')

@section('content')
    <div class="container">
        <vehicle-table
                       back-url="{{route('setting')}}"
                       company-url="{{route('api.vehicle.companies')}}"
                       resource-url="{{route('api.vehicle.index')}}"
                       title="{{__('vehicle.vehicle_list')}}"
        ></vehicle-table>
    </div>
@endsection