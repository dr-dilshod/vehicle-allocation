@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="very-center">
            <h4>{!!__('errors.unauthorized')!!}</h4>
            <a href="/" class="btn btn-warning">&laquo; {{__('driver.back')}}</a>
        </div>
    </div>
@endsection
