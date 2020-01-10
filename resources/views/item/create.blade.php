@extends('layouts.app')

@section('content')
    <div class="container">
        <item-registration back-url="{{route('setting')}}"
                       title="Item Registration"
        ></item-registration>
    </div>
@endsection
