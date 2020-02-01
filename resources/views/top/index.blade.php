@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row p-2">
            <div class="col-4">
                <a href="{{route('item.create')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.item_reg')}}</a>
            </div>
            <div class="col-4">
                <a href="{{route('item.index')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.item_list')}}</a>
            </div>
            <div class="col-4">
                <a href="{{route('dispatch.index')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.dispatch_board')}}</a>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-4">
                <a href="{{route('invoice.index')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.billing_management')}}</a>
            </div>
            <div class="col-4">
                <a href="{{route('payment.registration')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.payment_reg')}}</a>
            </div>
            <div class="col-4">
                <a href="{{route('top')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.deposit_list')}}</a>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-4">
                <a href="{{route('setting')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.settings')}}</a>
            </div>
        </div>
        <div class="row p-4">
            <div class="col-4">
                <form action="#" role="form">
                    <div class="form-group row">
                        <label for="year" class="col-2 offset-2">{{__('Year')}}</label>
                        <select class="form-control col-7" name="year" id="year">
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                            <option value="2022">2022</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <label for="month" class="col-2 offset-2">{{__('Month')}}</label>
                        <select class="form-control col-7" name="month" id="month">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-9 offset-2 pr-0">
                            <button type="submit" id="display" class="btn btn-lg btn-block btn-primary">{{__('Display')}}</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-8">

            </div>
        </div>
    </div>
@endsection
