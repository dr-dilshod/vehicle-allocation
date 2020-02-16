@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
               <h3 class="offset-md-6 pl-3">{{ __('common.login') }}</h3>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="driver_name" class="col-md-4 col-form-label text-md-right">{{ __('common.username') }}</label>

                            <div class="col-md-6">
                                <input id="driver_name" type="text" class="form-control @error('driver_id') is-invalid @enderror" name="driver_id" value="{{  old('driver_id') }}" required autocomplete="driver_id" autofocus>

                                @error('driver_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('common.password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-6">
                                <button name="login" type="submit" class="btn btn-warning btn-lg">
                                    {{ __('common.login') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection
