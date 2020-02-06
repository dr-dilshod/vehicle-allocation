@extends('layouts.app')

@section('content')
    <div class="container">
        <invoice invoice-url="{{route('invoice.list')}}"
                 back-url="{{route('top')}}"
                 shippers-url="{{route('shipper.list')}}"
                 vehicles-url="{{route('api.driver.vehicle-numbers')}}"
                 resource-url="/api/invoice"
                 title="{{__('invoice.invoice_list')}}"
                 payment-url="{{route('payment.list')}}"
                 deposit-url="{{route('deposit.list')}}"
                 billing-month-url="{{route('billing.month')}}"
        ></invoice>
    </div>
@endsection
