@extends('layouts.app')

@section('content')
    <div class="container">
        <payment-bk-report
                resource-url="{{route('api.payment.bk-report')}}"
                back-url="{{route('setting')}}"
        ></payment-bk-report>
    </div>
@endsection