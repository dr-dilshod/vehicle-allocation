@extends('layouts.app')

@section('content')
    <div class="container">
        <invoice fetch-url="{{ route('api.invoice.index') }}"
                 back-url="{{route('setting')}}"
                 shippers-url="{{route('api.shipper.distinct-name')}}"
                 vehicles-url="{{route('api.driver.vehicle-numbers')}}"
                 resource-url="/api/vehicle"
                 title="Invoice list"
        ></invoice>
    </div>
@endsection