@extends('layouts.app')

@section('content')
    <div class="container">
        <deposit-report
                resource-url="{{route('api.deposit.index')}}"
                shipper-url="{{route('api.shipper.distinct-name')}}"
                back-url="{{route('setting')}}"
        ></deposit-report>
    </div>
@endsection