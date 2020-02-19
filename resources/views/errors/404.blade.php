@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="very-center">
            <h4>{!! __('errors.not_found') !!}</h4>
            <a href="{{route('top')}}" class="btn btn-warning">&laquo; {{__('common.back')}}</a>
        </div>
    </div>
    @endsection
