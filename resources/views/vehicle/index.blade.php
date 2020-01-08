@extends('layouts.app')

@section('content')
    <div class="container">
        <vehicle-table fetch-url="{{ route('vehicle.table') }}"
                       back-url="{{route('setting')}}"
                       company-url="{{route('vehicle.companies')}}"
                       title="Vehicle list"
        ></vehicle-table>
    </div>
@endsection