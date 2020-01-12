@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('top')}}"
                           shipper-url="{{route('shipper.shippers')}}"
                           driver-url="{{route('driver.drivers')}}"
                           title="Item Registration"
        ></item-registration>
    </div>
@endsection
