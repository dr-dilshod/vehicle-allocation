<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * @property integer $item_id
 * @property integer $shipper_id
 * @property integer $driver_id
 * @property integer $create_id
 * @property integer $update_id
 * @property string $vehicle_no
 * @property boolean $status
 * @property string $stack_date
 * @property string $stack_time
 * @property string $down_date
 * @property string $down_time
 * @property boolean $down_invoice
 * @property string $stack_point
 * @property string $down_point
 * @property int $weight
 * @property boolean $empty_pl
 * @property int $item_price
 * @property string $item_driver_name
 * @property string $vehicle_no3
 * @property string $shipper_name
 * @property string $item_vehicle
 * @property int $vehicle_payment
 * @property string $item_completion_date
 * @property string $item_remark
 * @property boolean $delete_flg
 * @property string $created_at
 * @property string $updated_at
 * @property string $remember_token
 * @property Driver $driver
 * @property Shipper $shipper
 * @property User $user
 * @property User $updateUser
 * @property Billing[] $billings
 * @property Dispatch[] $dispatches
 * @property UnitPrice[] $unitPrices
 */
class Item extends Model
{
    use BlameableTrait;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'item_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['shipper_id', 'driver_id', 'create_id', 'update_id', 'vehicle_no', 'status', 'stack_date', 'stack_time', 'down_date', 'down_time', 'down_invoice', 'stack_point', 'down_point', 'weight', 'empty_pl', 'item_price', 'item_driver_name', 'vehicle_no3', 'shipper_name', 'item_vehicle', 'vehicle_payment', 'item_completion_date', 'item_remark', 'delete_flg', 'created_at', 'updated_at', 'remember_token'];

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
    public function driver()
    {
        return $this->belongsTo('App\Driver', null, 'driver_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipper()
    {
        return $this->belongsTo('App\Shipper', null, 'shipper_id');
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
    public function billings()
    {
        return $this->hasMany('App\Billing', null, 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dispatches()
    {
        return $this->hasMany('App\Dispatch', null, 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unitPrices()
    {
        return $this->hasMany('App\UnitPrice', null, 'item_id');
    }
}
