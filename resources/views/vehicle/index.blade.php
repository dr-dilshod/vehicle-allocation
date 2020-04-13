@extends('layouts.app')

@section('content')
    <div class="container">
        <vehicle-table
                       back-url="{{route('setting')}}"
                       company-url="{{route('api.vehicle.companies')}}"
                       resource-url="{{route('api.vehicle.index')}}"
                       title="{{__('vehicle.vehicle_list')}}"
        ></vehicle-table>
        {{--<br><br><br>--}}
        {{--<vehicle-grid--}}
            {{--back-url="{{route('setting')}}"--}}
            {{--company-url="{{route('api.vehicle.companies')}}"--}}
            {{--fixed-cols="3"--}}
            {{--fetch-url="{{route('api.vehicle.index')}}"--}}
            {{--height="270px"--}}
            {{--title="{{__('vehicle.vehicle_list')}}"--}}
        {{--></vehicle-grid>--}}
    </div>
@endsection