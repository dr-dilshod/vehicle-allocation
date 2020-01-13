@extends('layouts.app')

@section('content')
    <div class="container">
        <driver-table   fetch-url="{{ route('driver.table') }}"
                        back-url="{{route('setting')}}"
                        resource-url="/api/driver"
                        title="Dirver list"
        ></driver-table>
    </div>
@endsection
