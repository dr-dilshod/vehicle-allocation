@extends('layouts.app')

@section('content')
    <dispatch
            fetch-url="{{ route('api.dispatch.index') }}"
            back-url="{{route('top')}}"
            third-list-url="{{ route('api.dispatch.third') }}"
            pdf-url="{{ route('dispatch.pdf') }}"
            title="{{__('dispatch.dispatch_board')}}"
    ></dispatch>
@endsection