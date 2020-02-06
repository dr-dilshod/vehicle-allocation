@extends('layouts.app')

@section('content')
    <div class="container">
        <item-list item-url="{{route('item.list')}}"
                   back-url="{{route('top')}}"
                   shipper-url="{{route('item.shippers.dropdown')}}"
                   vehicle-url="{{route('item.vehicleNumbers')}}"
                   registration-url="{{route('item.create')}}"
                   resource-url="/api/item"
               title="{{__('item.item_list')}}"
        ></item-list>
    </div>
@endsection
