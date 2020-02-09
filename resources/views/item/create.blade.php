@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('top')}}"
                           shipper-url="{{route('item.shippers')}}"
                           driver-url="{{route('item.drivers')}}"
                           vehicle-url="{{route('item.vehicles')}}"
                           unitprice-url="{{route('item.unit_price')}}"
                           resource-url="{{route('api.item.index')}}"
                           title="{{__('item.item_registration')}}"
                           operation="{{__('common.register')}}"
                           clearing="{{__('common.clear')}}"
                           item-id=""
        ></item-registration>
    </div>
@endsection
