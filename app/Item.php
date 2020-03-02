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
 * @property integer $vehicle_id
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
 * @property int $dispatch_status
 * @property Driver $driver
 * @property Shipper $shipper
 * @property Driver $createdUser
 * @property Driver $updatedUser
 * @property Invoice[] $invoices
 * @property Dispatch[] $dispatches
 * @property UnitPrice[] $unitPrices
 */
class Item extends Model
{
    use BlameableTrait;

    const DISPATCH_STATUS_IN_DISPATCH = 1;
    const DISPATCH_STATUS_OUT_DISPATCH = 0;
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
    protected $fillable = ['shipper_id', 'driver_id', 'create_id', 'update_id', 'vehicle_id', 'status',
        'stack_date', 'stack_time', 'down_date', 'down_time', 'down_invoice', 'stack_point', 'down_point',
        'weight', 'empty_pl', 'item_price', 'item_driver_name', 'vehicle_no3', 'shipper_name', 'item_vehicle',
        'vehicle_payment', 'item_completion_date', 'item_remark', 'delete_flg', 'created_at', 'updated_at', 'remember_token'];


    /**
     * @var array
     */
    public static $validationRules = [
        'shipper_id' => 'bail|required|exists:shippers,shipper_id|numeric',
        'driver_id' => 'nullable|exists:drivers,driver_id|numeric',
        'vehicle_id' => 'nullable|exists:vehicles,vehicle_id|numeric',
        'status' => 'nullable|max:1|min:0',
        'stack_date' => 'required',
        'down_date' => 'required',
        'down_invoice' => 'nullable|max:1|min:0',
        'stack_point' => 'required|string|max:60',
        'down_point' => 'required|string|max:60',
        'weight' => 'nullable|integer|max:9999999999',
        'empty_pl' => 'nullable|max:1|min:0',
        'item_price' => 'nullable|integer|max:9999999999',
        'item_driver_name' => 'nullable|string|max:60',
        'vehicle_no3' => 'nullable|string|max:4',
        'shipper_name' => 'nullable|string|max:60',
        'item_vehicle' => 'nullable|string|max:60',
        'vehicle_payment' => 'nullable|integer|max:9999999999',
        'delete_flg' => 'min:0|max:1',
        'item_remark' => 'nullable|max:255',
    ];



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdUser()
    {
        return $this->belongsTo('App\User', 'create_id');
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
    public function updatedUser()
    {
        return $this->belongsTo('App\Driver', 'update_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Invoice', null, 'item_id');
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
