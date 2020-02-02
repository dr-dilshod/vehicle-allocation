@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row p-2">
            <div class="col-4 p-2">
                <a href="{{route('item.create')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.item_reg')}}</a>
            </div>
            <div class="col-4 p-2">
                <a href="{{route('item.index')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.item_list')}}</a>
            </div>
            <div class="col-4 p-2">
                <a href="{{route('dispatch.index')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.dispatch_board')}}</a>
            </div>
        @if(Auth::user()->isAdmin())
            <div class="col-4 p-2">
                <a href="{{route('invoice.index')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.billing_management')}}</a>
            </div>
            <div class="col-4 p-2">
                <a href="{{route('payment.registration')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.payment_reg')}}</a>
            </div>
            <div class="col-4 p-2">
                <a href="{{route('top')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.deposit_list')}}</a>
            </div>
        @endif
            <div class="col-4 p-2">
                <a href="{{route('setting')}}" class="btn btn-lg btn-warning btn-block p-4">{{__('top.settings')}}</a>
            </div>
        </div>
        @if(Auth::user()->isAdmin())
            <top
                fetch-url="{{route('api.top.index')}}"
                month-url="{{route('api.top.month')}}"
            ></top>
        @endif
    </div>
@endsection
