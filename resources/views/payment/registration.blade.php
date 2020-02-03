@extends('layouts.app')

@section('content')
    <div class="container">
        <payment-registration
            resource-url="/api/payments"
            shipper-url="{{route('api.shipper.fullname')}}"
            back-url="{{route('top')}}"
        ></payment-registration>
    </div>
@endsection
