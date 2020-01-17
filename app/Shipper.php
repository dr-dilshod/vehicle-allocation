<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Shipper extends Model
{
    use BlameableTrait;
    const validationRules = [
    'shipper_no' => 'required|max:4',
    'shipper_name1' => 'max:60',
    'shipper_name2' => 'max:60',
    'shipper_kana_name1' => 'max:60',
    'shipper_kana_name2' => 'max:60',
    'shipper_company_abbreviation' => 'max:60',
    'postal_code' => 'max:8',
    'address1' => 'max:120',
    'address2' => 'max:120',
    'phone_number' => 'max:12',
    'fax_number' => 'max:12'
];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shippers';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'shipper_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['shipper_no', 'shipper_name1', 'shipper_name2', 'shipper_kana_name1', 'shipper_kana_name2', 'shipper_company_abbreviation', 'postal_code',
        'address1', 'address2', 'phone_number', 'fax_number', 'closing_date', 'payment_date', 'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
