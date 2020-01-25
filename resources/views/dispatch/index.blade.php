@extends('layouts.app')

@section('content')
    <dispatch
            fetch-url="{{ route('api.dispatch.index') }}"
            back-url="{{route('top')}}"
            resource-url="/api/dispatch"
            title="Dispatch board"
    ></dispatch>
@endsection