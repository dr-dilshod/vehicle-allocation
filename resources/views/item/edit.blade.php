@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('top')}}"
                           shipper-url="{{route('item.shippers')}}"
                           driver-url="{{route('item.drivers')}}"
                           vehicle-url="{{route('item.vehicles')}}"
                           resource-url="/api/item"
                           title="Item Registration"
                           operation="Update"
                           clearing="Delete"
                           item-id="{{$item_id}}">
        </item-registration>
    </div>
@endsection
