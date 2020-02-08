@extends('layouts.app')

@section('content')
    <div class="container">
        <driver-table   fetch-url="{{ route('driver.table') }}"
                        back-url="{{route('setting')}}"
                        resource-url="{{route('api.driver.index')}}"
                        title="{{__('driver.driver_list')}}"
        ></driver-table>
    </div>
@endsection
