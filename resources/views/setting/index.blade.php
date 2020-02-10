@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-2">
                <a href="{{route('top')}}"
                   class="btn btn-lg btn-warning btn-block">{{__('setting.back')}}</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">{{__('setting.setting')}}</h2>
            </div>
        </div>

        <div class="row mb-4 mt-4">
            <div class="col-4 offset-4">
                <a href="{{route('driver.index')}}"
                   class="btn btn-lg btn-warning btn-block p-4">{{__('setting.driver_list')}}</a>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-4 offset-4">
                <a href="{{route('shipper.index')}}"
                   class="btn btn-lg btn-warning btn-block p-4">{{__('setting.shipper_list')}}</a>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-4 offset-4">
                <a href="{{route('vehicle')}}"
                   class="btn btn-lg btn-warning btn-block p-4">{{__('setting.car_list')}}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-4 offset-4">
                <a href="{{route('unit-price.index')}}"
                   class="btn btn-lg btn-warning btn-block p-4">{{__('setting.list_of_unit_prices')}}</a>
            </div>
        </div>
    </div>
@endsection
