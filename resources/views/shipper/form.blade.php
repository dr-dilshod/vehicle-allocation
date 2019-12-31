<div class="form-group {{ $errors->has('shipper_no') ? 'has-error' : ''}}">
    <label for="shipper_no" class="control-label">{{ 'Shipper No' }}</label>
    <input class="form-control" name="shipper_no" type="text" id="shipper_no" value="{{ isset($shipper->shipper_no) ? $shipper->shipper_no : ''}}" required>
    {!! $errors->first('shipper_no', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipper_name1') ? 'has-error' : ''}}">
    <label for="shipper_name1" class="control-label">{{ 'Shipper Name1' }}</label>
    <input class="form-control" name="shipper_name1" type="text" id="shipper_name1" value="{{ isset($shipper->shipper_name1) ? $shipper->shipper_name1 : ''}}">
    {!! $errors->first('shipper_name1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipper_name2') ? 'has-error' : ''}}">
    <label for="shipper_name2" class="control-label">{{ 'Shipper Name2' }}</label>
    <input class="form-control" name="shipper_name2" type="text" id="shipper_name2" value="{{ isset($shipper->shipper_name2) ? $shipper->shipper_name2 : ''}}">
    {!! $errors->first('shipper_name2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipper_kana_name1') ? 'has-error' : ''}}">
    <label for="shipper_kana_name1" class="control-label">{{ 'Shipper Kana Name1' }}</label>
    <input class="form-control" name="shipper_kana_name1" type="text" id="shipper_kana_name1" value="{{ isset($shipper->shipper_kana_name1) ? $shipper->shipper_kana_name1 : ''}}">
    {!! $errors->first('shipper_kana_name1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipper_kana_name2') ? 'has-error' : ''}}">
    <label for="shipper_kana_name2" class="control-label">{{ 'Shipper Kana Name2' }}</label>
    <input class="form-control" name="shipper_kana_name2" type="text" id="shipper_kana_name2" value="{{ isset($shipper->shipper_kana_name2) ? $shipper->shipper_kana_name2 : ''}}">
    {!! $errors->first('shipper_kana_name2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('shipper_company_abbreviation') ? 'has-error' : ''}}">
    <label for="shipper_company_abbreviation" class="control-label">{{ 'Shipper Company Abbreviation' }}</label>
    <input class="form-control" name="shipper_company_abbreviation" type="text" id="shipper_company_abbreviation" value="{{ isset($shipper->shipper_company_abbreviation) ? $shipper->shipper_company_abbreviation : ''}}">
    {!! $errors->first('shipper_company_abbreviation', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('postal_code') ? 'has-error' : ''}}">
    <label for="postal_code" class="control-label">{{ 'Postal Code' }}</label>
    <input class="form-control" name="postal_code" type="text" id="postal_code" value="{{ isset($shipper->postal_code) ? $shipper->postal_code : ''}}">
    {!! $errors->first('postal_code', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('address1') ? 'has-error' : ''}}">
    <label for="address1" class="control-label">{{ 'Address1' }}</label>
    <input class="form-control" name="address1" type="text" id="address1" value="{{ isset($shipper->address1) ? $shipper->address1 : ''}}" >
    {!! $errors->first('address1', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('address2') ? 'has-error' : ''}}">
    <label for="address2" class="control-label">{{ 'Address2' }}</label>
    <input class="form-control" name="address2" type="text" id="address2" value="{{ isset($shipper->address2) ? $shipper->address2 : ''}}" >
    {!! $errors->first('address2', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('phone_number') ? 'has-error' : ''}}">
    <label for="phone_number" class="control-label">{{ 'Phone Number' }}</label>
    <input class="form-control" name="phone_number" type="text" id="phone_number" value="{{ isset($shipper->phone_number) ? $shipper->phone_number : ''}}" >
    {!! $errors->first('phone_number', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('fax_number') ? 'has-error' : ''}}">
    <label for="fax_number" class="control-label">{{ 'Fax Number' }}</label>
    <input class="form-control" name="fax_number" type="text" id="fax_number" value="{{ isset($shipper->fax_number) ? $shipper->fax_number : ''}}" >
    {!! $errors->first('fax_number', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('closing_date') ? 'has-error' : ''}}">
    <label for="closing_date" class="control-label">{{ 'Closing Date' }}</label>
    <input class="form-control" name="closing_date" type="number" id="closing_date" value="{{ isset($shipper->closing_date) ? $shipper->closing_date : ''}}" >
    {!! $errors->first('closing_date', '<p class="help-block">:message</p>') !!}
</div>
<div class="form-group {{ $errors->has('delete_flg') ? 'has-error' : ''}}">
    <input class="form-control" name="delete_flg" type="checkbox" id="delete_flg" value="{{ isset($shipper->delete_flg) ? $shipper->delete_flg : ''}}" >
    <label for="delete_flg" class="control-label">{{ 'Delete Flg' }}</label>
    {!! $errors->first('delete_flg', '<p class="help-block">:message</p>') !!}
</div>

<div class="form-group">
    <input class="btn btn-primary" type="submit" value="{{ $formMode === 'edit' ? 'Update' : 'Create' }}">
</div>
