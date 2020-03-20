@extends('layouts.app')

@section('content')
    <div class="container">
        <driver-table   fetch-url="{{ route('driver.table') }}"
                        back-url="{{route('setting')}}"
                        resource-url="{{route('api.driver.index')}}"
                        insert-url="{{route('api.driver.store')}}"
                        update-url="{{route('api.driver.update')}}"
                        delete-url="{{route('api.driver.destroy')}}"
                        title="{{__('driver.driver_list')}}"
        ></driver-table>
    </div>
@endsection
