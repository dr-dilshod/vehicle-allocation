@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>{!! __('errors.not_found') !!}</h4>
        <a href="/">&laquo; {{__('driver.back')}}</a>
    </div>
    @endsection
