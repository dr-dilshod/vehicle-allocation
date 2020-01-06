@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-2">
                <a href="{{route('top')}}"
                   class="btn btn-lg btn-warning btn-block p-1">{{('Back')}}</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">Item List</h2>
            </div>
            <div class="col-2 pull-right">
                <a href="{{route('top')}}"
                   class="btn btn-lg btn-warning btn-block p-1">{{('Sign up')}}</a>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-9">
                <div class="row">
                    <div class="col-4 mt-4">
                        <div class="form-group row">
                            <label for="weekdate"
                                   class="col-6 col-form-label ">{{ __('Weekday') }}</label>

                            <div class="col-6">
                                <input id="weekdate" type="date"
                                       class="form-control"
                                       name="weekday"
                                       autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 mt-4">
                        <div class="form-group row">
                            <label for="projectno"
                                   class="col-6 col-form-label ">{{ __('Shipper') }}</label>

                            <div class="col-6">
                                <select class="form-control" name="shipper" id="shipper">
                                    <option value="00"></option>
                                    <option value="01">shipper1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 mt-4">
                        <div class="form-group row">
                            <label for="status"
                                   class="col-6 col-form-label ">{{ __('status') }}</label>

                            <div class="col-6">
                                <select class="form-control" name="status" id="status">
                                    <option value="00"></option>
                                    <option value="01">complete</option>
                                    <option value="02">incomplete</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-4 mt-4">
                        <div class="form-group row">
                            <label for="loadingplace"
                                   class="col-6 col-form-label ">{{ __('Loading place') }}</label>

                            <div class="col-6">
                                <input id="loadingplace" type="text"
                                       class="form-control"
                                       name="loadingplace"
                                       autofocus>
                            </div>
                        </div>
                    </div>

                    <div class="col-4 mt-4">
                        <div class="form-group row">
                            <label for="uloadingplace"
                                   class="col-6 col-form-label">{{ __('item.unloading_place') }}</label>

                            <div class="col-6">
                                <input id="unloadingplace" type="text"
                                       class="form-control"
                                       name="unloadingplace"
                                       autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 mt-4">
                        <div class="form-group row">
                            <label for="vehicleno"
                                   class="col-6 col-form-label">{{ __('Vehicle No') }}</label>

                            <div class="col-6">
                                <select class="form-control" name="vehicleno" id="vehicleno">
                                    <option value="00"></option>
                                    <option value="01">shipper1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="row mt-5 mb-0">
                    <div class="col-6">
                        <a href="{{route('top')}}"
                           class="btn btn-lg btn-primary btn-block p-1 ">{{('Search')}}</a>
                    </div>
                    <div class="col-6">
                        <a href="{{route('top')}}"
                           class="btn btn-lg btn-primary btn-block p-1">{{('Clear')}}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <table class="table table-striped data-table">
                <thead>
                <tr>
                    <th>Status</th>
                    <th>Project No</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Shipper</th>
                    <th>Loading place</th>
                    <th>Unloading place</th>
                    <th>Amount of money</th>
                    <th>Billing date</th>
                    <th>Weight</th>
                    <th>Unit price</th>
                    <th>Vehicle</th>
                    <th>Title</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row" class="btn btn-danger btn-block">incomplete</th>
                    <td>1</td>
                    <td>2019/12/29</td>
                    <td>19:32</td>
                    <td>shipper1</td>
                    <td>Urgench</td>
                    <td>Tashkent</td>
                    <td>300$</td>
                    <td>2019/12/29</td>
                    <td>12</td>
                    <td>300$</td>
                    <td>123</td>
                    <td>free</td>
                </tr>
                <tr>
                    <th scope="row" class="btn btn-danger btn-block">incomplete</th>
                    <td>2</td>
                    <td>2019/12/29</td>
                    <td>19:34</td>
                    <td>shipper2</td>
                    <td>Urgench</td>
                    <td>Tashkent</td>
                    <td>300$</td>
                    <td>2019/12/29</td>
                    <td>12</td>
                    <td>300$</td>
                    <td>123</td>
                    <td>free</td>
                </tr>
                <tr>
                    <th scope="row" class="btn btn-primary btn-block">complete</th>
                    <td>3</td>
                    <td>2019/12/29</td>
                    <td>19:34</td>
                    <td>shipper3</td>
                    <td>Urgench</td>
                    <td>Tashkent</td>
                    <td>300$</td>
                    <td>2019/12/29</td>
                    <td>12</td>
                    <td>300$</td>
                    <td>123</td>
                    <td>free</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection
