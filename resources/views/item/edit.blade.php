@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('top')}}"
                           shipper-url="{{route('item.shippers')}}"
                           driver-url="{{route('item.drivers')}}"
                           vehicle-url="{{route('item.vehicles')}}"
                           unitprice-url="{{route('item.unitprice')}}"
                           resource-url="/api/item"
                           title="{{__('item.item_registration')}}"
                           operation="{{__('item.update')}}"
                           clearing="{{__('item.delete')}}"
                           item-id="{{$item_id}}">
        </item-registration>
    </div>
@endsection
