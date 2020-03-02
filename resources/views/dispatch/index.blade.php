@extends('layouts.app')

@section('content')
    <dispatch
            fetch-url="{{ route('api.dispatch.index') }}"
            back-url="{{route('top')}}"
            third-list-url="{{ route('api.dispatch.third') }}"
            third-list2-url="{{ route('api.dispatch.third2') }}"
            pdf-url="{{ route('dispatch.pdf') }}"
            title="{{__('dispatch.dispatch_board')}}"
    ></dispatch>
@endsection