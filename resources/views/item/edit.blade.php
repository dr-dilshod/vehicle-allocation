@extends('layouts.app')

@section('content')
    <div class="container">
        <item-edit back-url="{{route('top')}}"
                           title="Item Edit"
        ></item-edit>
    </div>
@endsection