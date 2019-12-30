@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <a href="{{route('home')}}"
                   class="btn btn-lg btn-warning btn-block p-1">{{__('vehicle.back')}}</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">{{__('vehicle.vehicle_list')}}</h2>
            </div>
            <div class="col-2">
                <a href="{{route('home')}}"
                   class="btn btn-lg btn-danger p-1 pl-2 pr-2">{{__('vehicle.register')}}</a>
                <a href="{{route('home')}}"
                   class="btn btn-lg btn-danger p-1 pl-3 pr-3">{{__('vehicle.edit')}}</a>
            </div>
        </div>
        <div class="row mt-4 mb-4">
            <form action="#" class="form-inline">
                <div class="form-group ml-3">
                    <label for="company_name">{{__('vehicle.company_name')}}</label>
                </div>
                <div class="form-group ml-3">
                    <input class="form-control" type="text" name="company_name" id="company_name">
                </div>
                <div class="form-group ml-3">
                    <button type="submit" class="btn btn-primary">{{__('vehicle.btn_search')}}</button>
                </div>
                <div class="form-group ml-3">
                    <button type="reset" class="btn btn-primary">{{__('vehicle.btn_clear')}}</button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-striped data-table">
                    <thead>
                    <tr>
                        <th>Vehicle No</th>
                        <th>Company name</th>
                        <th>Reading</th>
                        <th>Abbreviation</th>
                        <th>Postal code</th>
                        <th>Street address</th>
                        <th>Phone number</th>
                        <th>Fax number</th>
                        <th>Offset</th>
                        <th>Remarks</th>
                        <th>Editing</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($vehicles as $vehicle)
                        <tr>
                            <th>{{$vehicle["subcontract_no"]}}</th>
                            <td>{{$vehicle["company_name"]}}</td>
                            <td>{{$vehicle["company_kana_name"]}}</td>
                            <td>{{$vehicle["subcontract_company_abbreviation"]}}</td>
                            <td>{{$vehicle["subcontract_postal_code"]}}</td>
                            <td>{{$vehicle["subcontract_address1"]}} {{$vehicle["subcontract_address2"]}}</td>
                            <td>{{$vehicle["subcontract_phone_number"]}}</td>
                            <td>{{$vehicle["subcontract_fax_number"]}}</td>
                            <td>{{$vehicle["offset"]}}</td>
                            <td>{{$vehicle["subcontract_remark"]}}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">
                                <p class="text-center">No data to show</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="11">
                            {{$vehicles->links()}}
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection