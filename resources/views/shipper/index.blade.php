@extends('layouts.app')

@section('content')
    <div class="container">
        <shipper-table fetch-url="{{ route('shipper-api.index') }}"
                       back-url="{{route('setting')}}"
                       company-url="{{route('vehicle.companies')}}"
                       title="Shipper list"
        ></shipper-table>
    </div>
@endsection

{{--@section('content')--}}
    {{--<div class="container">--}}
        {{--<div class="row">--}}

            {{--<div class="col-md-12">--}}
                {{--<div class="card">--}}
                    {{--<div class="card-body">--}}
                        {{--<div class="text-center">--}}
                            {{--<a href="{{ url('/shipper/create') }}" class="btn btn-warning float-left" title="Add New Shipper">--}}
                                {{--<i class="fa fa-plus" aria-hidden="true"></i> Back--}}
                            {{--</a>--}}
                            {{--<span class="h2">Title</span>--}}
                            {{--<a href="{{ url('/shipper/create') }}" class="btn btn-danger float-right" title="Add New Shipper">--}}
                                {{--<i class="fa fa-plus" aria-hidden="true"></i> Edit--}}
                            {{--</a>--}}
                            {{--<a href="{{ url('/shipper/create') }}" class="btn btn-danger float-right mr-2" title="Add New Shipper">--}}
                                {{--<i class="fa fa-plus" aria-hidden="true"></i> Registration--}}
                            {{--</a>--}}
                        {{--</div>--}}

                        {{--<div class="row mt-5">--}}
                            {{--<div class="mx-auto">--}}
                                {{--<form class="form-inline" id="searchForm" method="GET" action="{{ url('/shipper') }}" accept-charset="UTF-8">--}}
                                    {{--<div class="form-group mb-2">--}}
                                        {{--<label for="shipper">Shipper </label>--}}
                                        {{--<input type="text" class="form-control ml-2" id="shipper"--}}
                                               {{--name="shipper" value="{{ request('shipper') }}" />--}}
                                    {{--</div>--}}
                                    {{--<div class="form-group mx-sm-3 mb-2">--}}
                                        {{--<label for="billingAddress" >Billing address </label>--}}
                                        {{--<input type="text" class="form-control ml-2" id="billingAddress"--}}
                                               {{--name="billingAddress" value="{{ request('billingAddress') }}" />--}}
                                    {{--</div>--}}
                                    {{--<input type="submit" class="btn btn-primary mx-sm-2 mb-2" value="Search"/>--}}

                                    {{--<input type="reset" onclick="clearFields();" class="btn btn-primary mb-2 reset" value="Clear" />--}}
                                {{--</form>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<br/>--}}
                        {{--<br/>--}}
                        {{--<div class="table-responsive">--}}
                            {{--<table class="table" id="#table">--}}
                                {{--<thead>--}}
                                    {{--<tr>--}}
                                        {{--<th>#</th>--}}
                                        {{--<th>Shipper No</th>--}}
                                        {{--<th>Shipper</th>--}}
                                        {{--<th>Reading</th>--}}
                                        {{--<th>Abbreviation</th>--}}
                                        {{--<th>Postal Code</th>--}}
                                        {{--<th>Address1</th>--}}
                                        {{--<th>Address2</th>--}}
                                        {{--<th>Phone number</th>--}}
                                        {{--<th>FAX number</th>--}}
                                        {{--<th>Closing date</th>--}}
                                        {{--<th>Actions</th>--}}
                                    {{--</tr>--}}
                                {{--</thead>--}}
                                {{--<tbody>--}}
                                {{--@foreach($shipper as $item)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{ $loop->iteration }}</td>--}}
                                        {{--<td>{{ $item->shipper_no }}</td>--}}
                                        {{--<td>{{ $item->shipper_name1 }}</td>--}}
                                        {{--<td>{{ $item->shipper_name2 }}</td>--}}
                                        {{--<td>{{ $item->shipper_company_abbreviation }}</td>--}}
                                        {{--<td>{{ $item->postal_code }}</td>--}}
                                        {{--<td>{{ $item->address1 }}</td>--}}
                                        {{--<td>{{ $item->address2 }}</td>--}}
                                        {{--<td>{{ $item->phone_number }}</td>--}}
                                        {{--<td>{{ $item->fax_number }}</td>--}}
                                        {{--<td>{{ $item->closing_date }}</td>--}}
                                        {{--<td>--}}
                                            {{--<a href="{{ url('/shipper/' . $item->id) }}" title="View Shipper"><button class="btn btn-info btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> View</button></a>--}}
                                            {{--<a href="{{ url('/shipper/' . $item->id . '/edit') }}" title="Edit Shipper"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>--}}

                                            {{--<form method="POST" action="{{ url('/shipper' . '/' . $item->id) }}" accept-charset="UTF-8" style="display:inline">--}}
                                                {{--{{ method_field('DELETE') }}--}}
                                                {{--{{ csrf_field() }}--}}
                                                {{--<button type="submit" class="btn btn-danger btn-sm" title="Delete Shipper" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>--}}
                                            {{--</form>--}}
                                        {{--</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                                {{--</tbody>--}}
                            {{--</table>--}}
                            {{--<div class="pagination-wrapper"> {!! $shipper->appends(['search' => Request::get('search')])->render() !!} </div>--}}
                        {{--</div>--}}

                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endsection--}}
{{--<script>--}}
    {{--function clearFields() {--}}
        {{--var form = document.getElementById('searchForm');--}}
        {{--form.shipper.innerHTML('');--}}
        {{--form.billingAddress.innerHTML('');--}}
    {{--}--}}
{{--</script>--}}