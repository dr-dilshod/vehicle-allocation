@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('admin.sidebar')

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">Shipper {{ $shipper->id }}</div>
                    <div class="card-body">

                        <a href="{{ url('/shipper') }}" title="Back"><button class="btn btn-warning btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</button></a>
                        <a href="{{ url('/shipper/' . $shipper->id . '/edit') }}" title="Edit Shipper"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a>

                        <form method="POST" action="{{ url('shipper' . '/' . $shipper->id) }}" accept-charset="UTF-8" style="display:inline">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-danger btn-sm" title="Delete Shipper" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                        </form>
                        <br/>
                        <br/>

                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>ID</th><td>{{ $shipper->id }}</td>
                                    </tr>
                                    <tr><th> Shipper No </th><td> {{ $shipper->shipper_no }} </td></tr><tr><th> Shipper Name1 </th><td> {{ $shipper->shipper_name1 }} </td></tr><tr><th> Shipper Name2 </th><td> {{ $shipper->shipper_name2 }} </td></tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
