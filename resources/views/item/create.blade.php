@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('top')}}"
                           shipper-url="{{route('item.shippers')}}"
                           driver-url="{{route('item.drivers')}}"
                           vehicle-url="{{route('item.vehicles')}}"
                           unit-price-url="{{route('item.unit_price')}}"
                           resource-url="{{route('api.item.index')}}"
                           redirect-url="{{URL::to('/top')}}"
                           title="{{__('item.item_registration')}}"
                           operation="{{__('common.register')}}"
                           clearing="{{__('common.clear')}}"
        ></item-registration>
    </div>
@endsection
