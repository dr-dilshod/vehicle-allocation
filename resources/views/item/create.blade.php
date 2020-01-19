@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('top')}}"
                           shipper-url="{{route('item.shippers')}}"
                           driver-url="{{route('item.drivers')}}"
                           vehicle-url="{{route('vehicle.companies')}}"
                           resource-url="/api/item"
                           title="Item Registration"
        ></item-registration>
    </div>
@endsection
