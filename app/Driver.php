<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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
 * @property Driver $createdUser
 * @property Driver $updatedUser
 * @property Dispatch[] $dispatches
 * @property Item[] $items
 * @property UnitPrice[] $unitPrices
 */
class Driver extends Authenticatable
{
    use Notifiable;

    const SEARCH_FLAG_WORKING = 0;
    const SEARCH_FLAG_QUIT = 1;

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
    public function createdUser()
    {
        return $this->belongsTo('App\Driver', 'create_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedUser()
    {
        return $this->belongsTo('App\Driver', 'update_id');
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

    public static function getSearchFlagValues(){
        return [
            self::SEARCH_FLAG_WORKING => 'Working',
            self::SEARCH_FLAG_QUIT => 'Quit'
        ];
    }

    public function getAuthPassword()
    {
        return $this->driver_pass;
    }
}
