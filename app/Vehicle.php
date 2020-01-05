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


}
