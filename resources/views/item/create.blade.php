@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('top')}}"
                           shipper-url="{{route('api.shipper.all')}}"
                           driver-url="{{route('api.driver.drivers')}}"
                           vehicle-url="{{route('vehicle.companies')}}"
                           resource-url="/api/item"
                           fetch-url="{{'api.item.show'}}"
                           title="Item Registration"
                           operation="Registration"
                           clearing="Clear"
                           item-id=""
        ></item-registration>
    </div>
@endsection
