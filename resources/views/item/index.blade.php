@extends('layouts.app')

@section('content')
    <div class="container">
        <item-list item-url="{{route('item.list')}}"
                   back-url="{{route('top')}}"
                   shipper-url="{{route('item.shippers.dropdown')}}"
                   vehicle-url="{{route('item.vehicleNumbers')}}"
                   registration-url="{{route('item.register')}}"
                   resource-url="{{route('api.item.index')}}"
                   title="{{__('item.item_list')}}"
                   item-edit-url="{{route('item.edit')}}"
        ></item-list>
    </div>
@endsection
