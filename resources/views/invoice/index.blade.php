@extends('layouts.app')

@section('content')
    <div class="container">
        <invoice invoice-url="{{route('invoice.list')}}"
                 back-url="{{route('setting')}}"
                 shippers-url="{{route('api.shipper.distinct-name')}}"
                 vehicles-url="{{route('api.driver.vehicle-numbers')}}"
                 resource-url="/api/invoice"
                 title="Invoice list"
        ></invoice>
    </div>
@endsection
