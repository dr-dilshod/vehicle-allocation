@extends('layouts.app')

@section('content')
    <dispatch
            register-url="{{ route('api.dispatch.store') }}"
            back-url="{{route('top')}}"
            first-list-url="{{ route('api.dispatch.first') }}"
            second-list-url="{{ route('api.dispatch.second') }}"
            third-list-url="{{ route('api.dispatch.list') }}"
            driver-list-url="{{ route('api.dispatch.drivers') }}"
            pdf-url="{{ route('dispatch.pdf') }}"
    ></dispatch>
@endsection