@extends('layouts.app')

@section('content')
    <div class="container">
        <item-list item-url="{{route('item.list')}}"
               back-url="{{route('top')}}"
               shipper-url="{{route('api.shipper.all')}}"
               vehicle-url="{{route('api.vehicle.vehicleNumbers')}}"
               shipper-url="{{route('item.shippers.dropdown')}}"
               vehicle-url="{{route('item.vehicleNumbers')}}"
               registration-url="{{route('item.create')}}"
               title="Item list"
        ></item-list>
    </div>
@endsection
