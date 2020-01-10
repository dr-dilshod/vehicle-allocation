<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Vehicle extends Model
{
    use BlameableTrait;
    //
    protected $fillable = [
        'vehicle_no','company_name','company_kana_name','vehicle_company_abbreviation',
        'vehicle_postal_code','vehicle_address1','vehicle_address2','vehicle_phone_number',
        'vehicle_fax_number','offset','vehicle_remark','delete_flg'
    ];

    protected $primaryKey = 'vehicle_id';

    public static $validationRules = [
        'vehicle_no' => 'required|unique:vehicles|max:4',
        'company_name' => 'required|max:191',
        'company_kana_name' => 'required|max:191',
        'vehicle_company_abbreviation' => 'max:191',
        'vehicle_postal_code' => 'max:191',
        'vehicle_address1' => 'max:191',
        'vehicle_address2' => 'max:191',
        'vehicle_phone_number' => 'max:15',
        'vehicle_fax_number' => 'max:15',
        'vehicle_offset' => 'min:0|max:1',
        'delete_flg' => 'min:0|max:1',
    ];
}
