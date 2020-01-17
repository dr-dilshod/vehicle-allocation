@extends('layouts.app')

@section('content')
    <div class="container">
        <item-list item-url="{{route('api.item.list')}}"
               back-url="{{route('top')}}"
               shipper-url="{{route('api.shipper.shippers')}}"
               vehicle-url="{{route('api.vehicle.vehicleNumbers')}}"
               registration-url="{{route('item.create')}}"
               title="Item list"
        ></item-list>
    </div>
@endsection
