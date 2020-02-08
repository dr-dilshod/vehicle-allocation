@extends('layouts.app')

@section('content')
    <div class="container">
        <shipper-table
                resource-url="{{route('api.shipper.index')}}"
                back-url="{{route('setting')}}">

        </shipper-table>
    </div>
@endsection