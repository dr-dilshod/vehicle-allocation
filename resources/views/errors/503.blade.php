@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{!! __('errors.service_unavailable') !!}</h4>
        <a href="/">&laquo; {{__('driver.back')}}</a>
    </div>
@endsection
