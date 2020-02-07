@extends('layouts.app')

@section('content')
    <div class="container">
        <vehicle-table fetch-url="{{ route('vehicle.table') }}"
                       back-url="{{route('setting')}}"
                       company-url="{{route('vehicle.companies')}}"
                       resource-url="{{route('api.vehicle.index')}}"
                       title="{{__('vehicle.vehicle_list')}}"
        ></vehicle-table>
    </div>
@endsection