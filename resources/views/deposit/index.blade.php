@extends('layouts.app')

@section('content')
    <div class="container">
        <deposit-report
                resource-url="{{route('api.deposit.report')}}"
                shipper-url="{{route('api.shipper.all')}}"
                back-url="{{route('setting')}}"
        ></deposit-report>
    </div>
@endsection