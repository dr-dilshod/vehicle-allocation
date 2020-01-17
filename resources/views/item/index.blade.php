@extends('layouts.app')

@section('content')
    <div class="container">
        <item-list item-url="{{route('item.list')}}"
               back-url="{{route('top')}}"
               shipper-url="{{route('shipper.shippers')}}"
               vehicle-url="{{route('vehicle.vehicleNumbers')}}"
               registration-url="{{route('item.create')}}"
               title="Item list"
        ></item-list>
    </div>
@endsection
