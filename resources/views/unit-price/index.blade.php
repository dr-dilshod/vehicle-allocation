@extends('layouts.app')

@section('content')
    <div class="container">
        <unit-price-table
            resource-url="api/unit-prices"
            back-url="{{route('setting')}}"
            title="Unit price list"
        ></unit-price-table>
    </div>
@endsection
