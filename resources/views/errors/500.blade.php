@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{!! __('errors.server_error') !!}</h4>
        <a href="/">&laquo; {{__('driver.back')}}</a>
    </div>
@endsection
