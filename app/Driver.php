<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

class Driver extends Model
{
    use BlameableTrait;
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
    protected $primaryKey = 'driver_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['driver_pass', 'driver_name', 'driver_mobile_number', 'maximum_Loading', 'search_flg', 'admin_flg', 'vehicle_no1', 'vehicle_no2', 'vehicle_no3', 'vehicle_type', 'driver_remark', 'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
