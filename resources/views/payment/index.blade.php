@extends('layouts.app')

@section('content')
    <div class="container">
        <payment-list
                resource-url="{{route('api.payment.index')}}"
                shipper-url="{{route('api.shipper.all')}}"
                back-url="{{route('setting')}}"
        ></payment-list>
    </div>
@endsection