@extends('layouts.app')

@section('content')
    <div class="container">
        <deposit-registration
                resource-url="/api/deposits"
                shipper-url="{{route('api.shipper.fullname')}}"
                back-url="{{route('top')}}"
        ></deposit-registration>
    </div>
@endsection