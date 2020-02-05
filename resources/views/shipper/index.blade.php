@extends('layouts.app')

@section('content')
    <div class="container">
        <shipper-table
                resource-url="/api/shippers"
                back-url="{{route('setting')}}">

        </shipper-table>
    </div>
@endsection