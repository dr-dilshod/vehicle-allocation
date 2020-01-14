@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="very-center">
            <h4>{!! __('errors.server_error') !!}</h4>
            <a href="/" class="btn btn-danger">&laquo; {{__('driver.back')}}</a>
        </div>
    </div>
@endsection
