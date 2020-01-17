<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $driver_id
 * @property integer $create_id
 * @property integer $update_id
 * @property string $driver_pass
 * @property string $driver_name
 * @property string $driver_mobile_number
 * @property string $maximum_Loading
 * @property boolean $search_flg
 * @property boolean $admin_flg
 * @property string $vehicle_no1
 * @property string $vehicle_no2
 * @property string $vehicle_no3
 * @property string $vehicle_type
 * @property string $driver_remark
 * @property boolean $delete_flg
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property User $updateUser
 * @property Dispatch[] $dispatches
 * @property Item[] $items
 * @property UnitPrice[] $unitPrices
 */
class Driver extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'driver_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['create_id', 'update_id', 'driver_pass', 'driver_name', 'driver_mobile_number', 'maximum_Loading', 'search_flg', 'admin_flg', 'vehicle_no1', 'vehicle_no2', 'vehicle_no3', 'vehicle_type', 'driver_remark', 'delete_flg', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'create_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updateUser()
    {
        return $this->belongsTo('App\User', 'update_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dispatches()
    {
        return $this->hasMany('App\Dispatch', null, 'driver_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Item', null, 'driver_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unitPrices()
    {
        return $this->hasMany('App\UnitPrice', null, 'driver_id');
    }
}
