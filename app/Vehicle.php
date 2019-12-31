<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Vehicle extends Model
{
    use BlameableTrait;
    //
    protected $fillable = [
        'subcontract_no','company_name','company_kana_name','subcontract_company_abbreviation',
        'subcontract_postal_code','subcontract_address1','subcontract_address2','subcontract_phone_number',
        'subcontract_fax_number','offset','subcontract_remark','delete_flg'
    ];

    protected $primaryKey = 'subcontract_id';


}
