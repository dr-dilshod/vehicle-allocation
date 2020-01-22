@extends('layouts.app')

@section('content')
    <div class="container">
        <deposit-list
                resource-url="{{route('api.deposit.index')}}"
                shipper-url="{{route('api.shipper.all')}}"
                back-url="{{route('setting')}}"
        ></deposit-list>
    </div>
@endsection