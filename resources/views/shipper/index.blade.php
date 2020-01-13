@extends('layouts.app')

@section('content')
    <div class="container">
        <shipper-table
                resource-url="{{route('api.shipper.index')}}"
                back-url="{{route('setting')}}"
                shipper-name-url="{{route('api.shipper.distinct-name')}}"
                company-url="{{route('api.shipper.distinct-company')}}"
                title="Shipper list"
        ></shipper-table>
    </div>
@endsection