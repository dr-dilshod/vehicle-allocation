@extends('layouts.app')

@section('content')
    <div class="container">
        <unit-price-table
            resource-url="{{route('api.unit-price.index')}}"
            back-url="{{route('setting')}}"
            title="Unit price list"
        ></unit-price-table>
    </div>
@endsection
