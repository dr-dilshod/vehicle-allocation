@extends('layouts.app')

@section('content')
    <div class="container">
        <deposit-registration
                resource-url="{{route('api.deposit.index')}}"
                shipper-url="{{route('api.shipper.fullname')}}"
                back-url="{{route('top')}}"
        ></deposit-registration>
    </div>
@endsection