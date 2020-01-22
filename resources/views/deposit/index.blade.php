@extends('layouts.app')

@section('content')
    <div class="container">
        <deposit-list
                resource-url="{{route('api.deposit.index')}}"
                back-url="{{route('setting')}}"
        ></deposit-list>
    </div>
@endsection