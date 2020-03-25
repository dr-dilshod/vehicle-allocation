@extends('layouts.app')

@section('content')
    <div class="container">
        <shipper-list
                resource-url="{{URL::to('/api/shippers')}}"
                back-url="{{route('setting')}}">

        </shipper-list>
    </div>
@endsection