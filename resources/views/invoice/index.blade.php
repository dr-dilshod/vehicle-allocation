@extends('layouts.app')

@section('content')
    <div class="container">
        <invoice aggr-url="{{route('api.invoice.aggregate')}}"
                 back-url="{{route('top')}}"
                 shippers-url="{{route('shipper.list')}}"
                 vehicles-url="{{route('vehicle.list')}}"
                 resource-url="{{route('api.invoice.index')}}"
                 title="{{__('invoice.invoice_list')}}"
                 payment-url="{{route('payment.list')}}"
                 deposit-url="{{route('deposit.list')}}"
                 billing-month-url="{{route('billing.month')}}"
                 billing-list-url="{{route('billing.list')}}"
                 stack-points-url="{{route('api.invoice.stackpoints')}}"
                 down-points-url="{{route('api.invoice.downpoints')}}"
        ></invoice>
    </div>
@endsection
