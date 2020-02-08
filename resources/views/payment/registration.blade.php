@extends('layouts.app')

@section('content')
    <div class="container">
        <payment-registration
            resource-url="{{route('api.payment.index')}}"
            shipper-url="{{route('api.shipper.fullname')}}"
            back-url="{{route('top')}}"
        ></payment-registration>
    </div>
@endsection
