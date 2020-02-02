@extends('layouts.app')

@section('content')
    <dispatch
            fetch-url="{{ route('api.dispatch.index') }}"
            back-url="{{route('top')}}"
            third-list-url="{{ route('api.dispatch.third') }}"
            title="{{__('Dispatch board')}}"
    ></dispatch>
@endsection