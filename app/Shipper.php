<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
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
    protected $fillable = ['shipper_no', 'shipper_name1', 'shipper_name2', 'shipper_kana_name1', 'shipper_kana_name2', 'shipper_company_abbreviation', 'postal_code', 'address1', 'address2', 'phone_number', 'fax_number', 'closing_date', 'payment_date', 'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model)
        {
            $user = Auth::user();
            if(!empty($user)){
                $model->create_id = $user->id;
                $model->update_id = $user->id;
            }
        });
        static::updating(function($model)
        {
            $user = Auth::user();
            if (!empty($user))
                $model->update_id = $user->id;
        });
    }
}
