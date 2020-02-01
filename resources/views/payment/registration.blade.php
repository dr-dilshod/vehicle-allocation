@extends('layouts.app')

@section('content')
    <div class="container">
        <payment-registration
            fetch-url="{{ route('driver.table') }}"
                resource-url="{{route('api.payment.registration')}}"
            search-url="{{route('payment.search')}}"
                shipper-url="{{route('payment.shippers')}}"
                back-url="{{route('setting')}}"
        ></payment-registration>
    </div>
@endsection
