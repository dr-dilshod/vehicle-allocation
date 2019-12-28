<div class="form-group {{ $errors->has('driver_pass') ? 'has-error' : ''}}">
    <label for="driver_pass" class="control-label">{{ 'Driver Pass' }}</label>
    <input class="form-control" name="driver_pass" type="text" id="driver_pass" value="{{ isset($driver->driver_pass) ? $driver->driver_pass : ''}}" required>
    {!! $errors->first('driver_pass', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('driver_name') ? 'has-error' : ''}}">
    <label for="driver_name" class="control-label">{{ 'Driver Name' }}</label>
    <input class="form-control" name="driver_name" type="text" id="driver_name" value="{{ isset($driver->driver_name) ? $driver->driver_name : ''}}" required>
    {!! $errors->first('driver_name', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('driver_mobile_number') ? 'has-error' : ''}}">
    <label for="driver_mobile_number" class="control-label">{{ 'Driver Mobile Number' }}</label>
    <input class="form-control" name="driver_mobile_number" type="text" id="driver_mobile_number" value="{{ isset($driver->driver_mobile_number) ? $driver->driver_mobile_number : ''}}" required>
    {!! $errors->first('driver_mobile_number', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('maximum_Loading') ? 'has-error' : ''}}">
    <label for="maximum_Loading" class="control-label">{{ 'Maximum Loading' }}</label>
    <input class="form-control" name="maximum_Loading" type="text" id="maximum_Loading" value="{{ isset($driver->maximum_Loading) ? $driver->maximum_Loading : ''}}" required>
    {!! $errors->first('maximum_Loading', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('search_flg') ? 'has-error' : ''}}">
    <label for="search_flg" class="control-label">{{ 'Search Flg' }}</label>
    <input class="form-control" name="search_flg" type="number" id="search_flg" value="{{ isset($driver->search_flg) ? $driver->search_flg : ''}}" required>
    {!! $errors->first('search_flg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('admin_flg') ? 'has-error' : ''}}">
    <label for="admin_flg" class="control-label">{{ 'Admin Flg' }}</label>
    <input class="form-control" name="admin_flg" type="number" id="admin_flg" value="{{ isset($driver->admin_flg) ? $driver->admin_flg : ''}}" required>
    {!! $errors->first('admin_flg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('car_no1') ? 'has-error' : ''}}">
    <label for="car_no1" class="control-label">{{ 'Car No1' }}</label>
    <input class="form-control" name="car_no1" type="text" id="car_no1" value="{{ isset($driver->car_no1) ? $driver->car_no1 : ''}}" required>
    {!! $errors->first('car_no1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('car_no2') ? 'has-error' : ''}}">
    <label for="car_no2" class="control-label">{{ 'Car No2' }}</label>
    <input class="form-control" name="car_no2" type="text" id="car_no2" value="{{ isset($driver->car_no2) ? $driver->car_no2 : ''}}" required>
    {!! $errors->first('car_no2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('car_no3') ? 'has-error' : ''}}">
    <label for="car_no3" class="control-label">{{ 'Car No3' }}</label>
    <input class="form-control" name="car_no3" type="text" id="car_no3" value="{{ isset($driver->car_no3) ? $driver->car_no3 : ''}}" required>
    {!! $errors->first('car_no3', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('car_type') ? 'has-error' : ''}}">
    <label for="car_type" class="control-label">{{ 'Car Type' }}</label>
    <input class="form-control" name="car_type" type="text" id="car_type" value="{{ isset($driver->car_type) ? $driver->car_type : ''}}" required>
    {!! $errors->first('car_type', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('driver_remark') ? 'has-error' : ''}}">
    <label for="driver_remark" class="control-label">{{ 'Driver Remark' }}</label>
    <input class="form-control" name="driver_remark" type="text" id="driver_remark" value="{{ isset($driver->driver_remark) ? $driver->driver_remark : ''}}" required>
    {!! $errors->first('driver_remark', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('delete_flg') ? 'has-error' : ''}}">
    <label for="delete_flg" class="control-label">{{ 'Delete Flg' }}</label>
    <input class="form-control" name="delete_flg" type="number" id="delete_flg" value="{{ isset($driver->delete_flg) ? $driver->delete_flg : ''}}" >
    {!! $errors->first('delete_flg', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('create_id') ? 'has-error' : ''}}">
    <label for="create_id" class="control-label">{{ 'Create Id' }}</label>
    <input class="form-control" name="create_id" type="number" id="create_id" value="{{ isset($driver->create_id) ? $driver->create_id : ''}}" >
    {!! $errors->first('create_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('created_at') ? 'has-error' : ''}}">
    <label for="created_at" class="control-label">{{ 'Created At' }}</label>
    <input class="form-control" name="created_at" type="datetime-local" id="created_at" value="{{ isset($driver->created_at) ? $driver->created_at : ''}}" >
    {!! $errors->first('created_at', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('update_id') ? 'has-error' : ''}}">
    <label for="update_id" class="control-label">{{ 'Update Id' }}</label>
    <input class="form-control" name="update_id" type="number" id="update_id" value="{{ isset($driver->update_id) ? $driver->update_id : ''}}" >
    {!! $errors->first('update_id', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('updated_at') ? 'has-error' : ''}}">
    <label for="updated_at" class="control-label">{{ 'Updated At' }}</label>
    <input class="form-control" name="updated_at" type="datetime-local" id="updated_at" value="{{ isset($driver->updated_at) ? $driver->updated_at : ''}}" >
    {!! $errors->first('updated_at', '<p class="help-block">:message</p>') !!}
</div>


<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
