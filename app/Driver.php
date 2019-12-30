<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'drivers';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['driver_pass', 'driver_name', 'driver_mobile_number', 'maximum_Loading', 'search_flg', 'admin_flg', 'car_no1', 'car_no2', 'car_no3', 'car_type', 'driver_remark', 'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
