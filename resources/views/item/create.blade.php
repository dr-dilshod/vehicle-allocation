@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('top')}}"
                           shipper-url="{{route('item.shippers')}}"
                           driver-url="{{route('item.drivers')}}"
                           vehicle-url="{{route('item.vehicles')}}"
                           unit-price-url="{{route('item.unit_price')}}"
                           resource-url="{{route('api.item.index')}}"
                           redirect-url="{{URL::to('/item')}}"
                           title="{{__('item.item_registration')}}"
                           operation="{{__('common.register')}}"
                           clearing="{{__('common.clear')}}"
                           stack-points-url="{{route('api.invoice.stackpoints')}}"
                           down-points-url="{{route('api.invoice.downpoints')}}"
                           unit-price="{{route('api.unit-prices.register')}}"
        ></item-registration>
    </div>
@endsection
