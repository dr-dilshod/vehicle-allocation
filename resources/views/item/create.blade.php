@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('top')}}"
                           shipper-url="{{route('item.shippers')}}"
                           driver-url="{{route('item.drivers')}}"
                           vehicle-url="{{route('item.vehicles')}}"
                           unitprice-url="/item/getUnitPrice"
                           resource-url="/api/item"
                           title="Item Registration"
                           operation="Registration"
                           clearing="Clear"
                           item-id=""
        ></item-registration>
    </div>
@endsection
