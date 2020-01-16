@extends('layouts.app')

@section('content')
    <div class="container">
        <invoice fetch-url="{{ route('vehicle.table') }}"
                 back-url="{{route('setting')}}"
                 shippers-url="{{route('vehicle.companies')}}"
                 vehicles-url="{{route('vehicle.companies')}}"
                 resource-url="/api/vehicle"
                 title="Invoice list"
        ></invoice>
    </div>
@endsection