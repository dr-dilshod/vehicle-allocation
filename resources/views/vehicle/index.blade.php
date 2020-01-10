@extends('layouts.app')

@section('content')
    <div class="container">
        <vehicle-table fetch-url="{{ route('vehicle.table') }}"
                       back-url="{{route('setting')}}"
                       company-url="{{route('vehicle.companies')}}"
                       resource-url="/api/vehicle"
                       title="Vehicle list"
        ></vehicle-table>
    </div>
@endsection