@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="very-center">
            <h4>{!! __('errors.too_many_requests') !!}</h4>
            <a href="{{Url::to('/')}}" class="btn btn-warning">&laquo; {{__('common.back')}}</a>
        </div>
    </div>
@endsection
