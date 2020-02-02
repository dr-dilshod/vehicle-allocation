@extends('layouts.app')

@section('content')
    <div class="container">
        <deposit-report
                resource-url="/api/deposits"
                shipper-url="{{route('api.shipper.fullname')}}"
                back-url="{{route('top')}}"
        ></deposit-report>
    </div>
@endsection