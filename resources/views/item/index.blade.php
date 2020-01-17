@extends('layouts.app')

@section('content')
    <div class="container">


        <item-list fetch-url="{{ route('item.index') }}"
                   back-url="{{route('top')}}"
                   shipper-name-url="{{route('api.shipper.distinct-name')}}"
                   vehicle-no-url="/api/item"
                   resource-url="/api/item"
                   title="Item list"
        ></item-list>
    </div>


@endsection
