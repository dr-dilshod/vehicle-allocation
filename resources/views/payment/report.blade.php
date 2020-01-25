@extends('layouts.app')

@section('content')
    <div class="container">
        <payment-report
                resource-url="{{route('api.payment.report')}}"
                shipper-url="{{route('api.shipper.all')}}"
                back-url="{{route('setting')}}"
        ></payment-report>
    </div>
@endsection