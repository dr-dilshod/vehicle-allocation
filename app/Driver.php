<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * @property integer $driver_id
 * @property integer $create_id
 * @property integer $update_id
 * @property string $driver_no
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

    use BlameableTrait;
    const validationRules = [
        'addedDrivers.*.vehicle_type' => 'max:10',
        'addedDrivers.*.driver_no' => 'required|max:4',
        'addedDrivers.*.driver_name' => 'required|max:60',
        'addedDrivers.*.driver_pass' => 'required|max:120',
        'addedDrivers.*.driver_mobile_number' => 'max:13',
        'addedDrivers.*.maximum_Loading' => 'max:5',
        'addedDrivers.*.vehicle_no3' => 'max:4',
        'addedDrivers.*.driver_remark' => 'max:255',
        'addedDrivers.*.search_flg' => 'max:1',
        'addedDrivers.*.admin_flg' => 'max:1',
    ];
    const updateRules = [
        'updatedDrivers.*.vehicle_type' => 'max:10',
        'updatedDrivers.*.driver_no' => 'required|max:4',
        'updatedDrivers.*.driver_name' => 'required|max:60',
        'updatedDrivers.*.driver_pass' => 'required|max:120',
        'updatedDrivers.*.driver_mobile_number' => 'max:13',
        'updatedDrivers.*.maximum_Loading' => 'max:5',
        'updatedDrivers.*.vehicle_no3' => 'max:4',
        'updatedDrivers.*.driver_remark' => 'max:255',
        'updatedDrivers.*.search_flg' => 'max:1',
        'updatedDrivers.*.admin_flg' => 'max:1',
    ];

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
    protected $fillable = ['driver_no', 'driver_pass', 'driver_name', 'driver_mobile_number', 'maximum_Loading', 'search_flg', 'admin_flg', 'vehicle_no1', 'vehicle_no2', 'vehicle_no3', 'vehicle_type', 'driver_remark', 'delete_flg', 'created_at', 'updated_at', 'create_id', 'update_id'];

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
        return $this->hasMany('App\Dispatch', 'driver_id', 'driver_id');
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

    public function getItemsByDate($date){
//        $dispatches = Dispatch::where([])
    }

    public function isAdmin(){
        return $this->admin_flg;
    }
}
