@extends('layouts.app')

@section('content')
    <div class="container">
        <driver-table   fetch-url="{{ route('api.driver.index') }}"
                        back-url="{{route('setting')}}"
                        resource-url="{{route('api.driver.store')}}"
                        title="{{__('driver.driver_list')}}"
        ></driver-table>
    </div>
@endsection
