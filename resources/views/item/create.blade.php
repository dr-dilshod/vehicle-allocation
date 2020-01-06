@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-2">
                <a href="{{route('top')}}"
                   class="btn btn-lg btn-warning btn-block p-1">{{('Back')}}</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">Item Registration</h2>
            </div>
            <div class="row">
                <div class="col-6 pull-right">
                    <a href="{{route('top')}}"
                       class="btn btn-lg btn-danger btn-block p-1">{{('Register')}}</a>
                </div>
                <div class="col-6 pull-right">
                    <a href="{{route('top')}}"
                       class="btn btn-lg btn-danger btn-block p-1">{{('Remove')}}</a>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-8">
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
                    <div class="col-5 mt-4">
                        <div class="form-group row">
                            <label for="producttime"
                                   class="col-6 col-form-label ">{{ __('Product time') }}</label>
                            <div class="col-6">
                                <select class="form-control" name="producttime" id="producttime">
                                    <option value="00"></option>
                                    <option value="01">01</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="form-group row">
                            <label
                                    class="col-3 col-form-label ">{{ __(':') }}</label>
                            <div class="col-9">
                                <select class="form-control" name="min" id="min">
                                    <option value="00"></option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="width: 25rem;">
                <div class=" form-check">
                    <input type="checkbox" class="form-check-input" style="width: 10rem;" id="billing">
                    <label class="form-check-label" for="materialUnchecked">Billing</label>
                </div>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-8">
                <div class="row">
                    <div class="col-4 mt-4">
                        <div class="form-group row">
                            <label for="laterdate"
                                   class="col-6 col-form-label ">{{ __('Later date') }}</label>
                            <div class="col-6">
                                <input id="laterdate" type="date"
                                       class="form-control"
                                       name="laterdate"
                                       autofocus>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 mt-4">
                        <div class="form-group row">
                            <label for="falltime"
                                   class="col-6 col-form-label ">{{ __('Fall time') }}</label>
                            <div class="col-6">
                                <select class="form-control" name="falltime" id="falltime">
                                    <option value="00"></option>
                                    <option value="01">01</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 mt-4">
                        <div class="form-group row">
                            <label
                                    class="col-3 col-form-label ">{{ __(':') }}</label>
                            <div class="col-9">
                                <select class="form-control" name="min" id="min">
                                    <option value="00"></option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="loadingport"
                           class="col-6 col-form-label ">{{ __('Loading port') }}</label>
                    <div class="col-6">
                        <input id="loadingport" type="text"
                               class="form-control"
                               name="loadingport"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="drop_off"
                           class="col-6 col-form-label ">{{ __('Drop off') }}</label>
                    <div class="col-6">
                        <input id="drop_off" type="text"
                               class="form-control"
                               name="drop_off"
                               autofocus>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label
                            class="col-6 col-form-label ">{{ __('Shipper') }}</label>
                    <div class="col-6">
                        <select class="form-control" name="shipper" id="shipper">
                            <option value="00"></option>
                            <option value="01">Shipper1</option>
                            <option value="02">Shipper2</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="vehicle_no"
                           class="col-6 col-form-label ">{{ __('Vehicle No') }}</label>
                    <div class="col-6">
                        <input id="vehicle_no" type="text"
                               class="form-control"
                               name="vehicle_no"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label
                            class="col-6 col-form-label ">{{ __('Driver name') }}</label>
                    <div class="col-6">
                        <select class="form-control" name="driver_name" id="driver_name">
                            <option value="00"></option>
                            <option value="01">driver1</option>
                            <option value="02">driver2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="t_number"
                           class="col-6 col-form-label ">{{ __('t number') }}</label>
                    <div class="col-6">
                        <input id="t_number" type="text"
                               class="form-control"
                               name="t_number"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label
                            class="col-6 col-form-label ">{{ __('t Empty') }}</label>
                    <div class="col-6">
                        <select class="form-control" name="t_empty" id="t_empty">
                            <option value="00"></option>
                            <option value="01">empty1</option>
                            <option value="02">empty2</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="per_ton"
                           class="col-6 col-form-label ">{{ __('Per ton') }}</label>
                    <div class="col-6">
                        <input id="per_ton" type="text"
                               class="form-control"
                               name="per_ton"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="yen"
                           class="col-6 col-form-label ">{{ __('yen') }}</label>
                    <div class="col-6">
                        <input id="circle" type="text"
                               class="form-control"
                               name="yen"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="t"
                           class="col-6 col-form-label ">{{ __('t') }}</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="per_vehicle"
                           class="col-6 col-form-label ">{{ __('Per vehicle') }}</label>
                    <div class="col-6">
                        <input id="per_vehicle" type="text"
                               class="form-control"
                               name="per_vehicle"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="yen1"
                           class="col-6 col-form-label ">{{ __('yen 1') }}</label>
                    <div class="col-6">
                        <input id="circle1" type="text"
                               class="form-control"
                               name="yen1"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="table"
                           class="col-6 col-form-label ">{{ __('table') }}</label>
                    <div class="col-6">
                        <input id="table" type="text"
                               class="form-control"
                               name="table"
                               autofocus>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="amount_of_money"
                           class="col-6 col-form-label">{{ __('Amount of money') }}</label>
                    <div class="col-6">
                        <input id="amount_of_money" type="text"
                               class="form-control bg-dark"
                               name="amount_of_money"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="yen3"
                           class="col-6 col-form-label ">{{ __('yen') }}</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label
                            class="col-6 col-form-label ">{{ __('Chartered car') }}</label>
                    <div class="col-6">
                        <select class="form-control" name="chartered_car" id="chartered_car">
                            <option value="00"></option>
                            <option value="01">car1</option>
                            <option value="02">car2</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="rental_car_payment"
                           class="col-6 col-form-label">{{ __('Rental car payment') }}</label>
                    <div class="col-6">
                        <input id="rental_car_payment" type="text"
                               class="form-control"
                               name="rental_car_payment"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-4">
                <div class="form-group row">
                    <label for="yen4"
                           class="col-6 col-form-label ">{{ __('yen') }}</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group row">
                <label for="rental_car_payment"
                       class="col-3 col-form-label">{{ __('Remarks') }}</label>
            </div>
            <div class=" col-8">
                <textarea class="form-control rounded-0" id="remarks" rows="3"></textarea>
            </div>
        </div>

    </div>


@endsection
