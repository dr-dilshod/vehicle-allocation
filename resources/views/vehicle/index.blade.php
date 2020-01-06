@extends('layouts.app')

@section('content')
    <div class="container">
        <vehicle-table fetch-url="{{ route('vehicle.table') }}" back-url="" title="Vehicle list"></vehicle-table>
    </div>
@endsection