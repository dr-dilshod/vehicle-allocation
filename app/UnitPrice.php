<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $price_id
 * @property integer $shipper_id
 * @property integer $item_id
 * @property integer $driver_id
 * @property integer $create_id
 * @property integer $update_id
 * @property boolean $type
 * @property integer $price
 * @property string $car_type
 * @property string $shipper_no
 * @property string $stack_point
 * @property string $down_point
 * @property boolean $delete_flg
 * @property string $created_at
 * @property string $updated_at
 * @property Driver $createdUser
 * @property Driver $updatedUser
 * @property Driver $driver
 * @property Item $item
 * @property Shipper $shipper
 */
class UnitPrice extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'price_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = [
        'shipper_id', 'item_id', 'driver_id', 'create_id',
        'update_id', 'type', 'price', 'delete_flg',
        'created_at', 'updated_at', 'car_type', 'shipper_no',
        'stack_point', 'down_point'
    ];

    /**
     * @var array
     */
    protected $hidden = ['delete_flg'];

    /**
     * @var array
     */
    public static $createValidationRules = [
        'shipper_id' => 'bail|required|exists:shippers,id|numeric',
        'item_id' => 'bail|required|exists:items,item_id|numeric',
        'driver_id' => 'bail|required|exists:drivers,driver_id|numeric',
        'type' => 'bail|required|numeric',
        'price' => 'bail|required|numeric',
    ];

    /**
     * @var array
     */
    public static $updateValidationRules = [
        'shipper_id' => 'bail|required|exists:shippers,id|numeric',
        'item_id' => 'bail|required|exists:items,item_id|numeric',
        'driver_id' => 'bail|required|exists:drivers,driver_id|numeric',
        'type' => 'bail|required|numeric',
        'price' => 'bail|required|numeric',
    ];

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
    public function driver()
    {
        return $this->belongsTo('App\Driver', 'driver_id', 'driver_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo('App\Item', 'item_id', 'item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipper()
    {
        return $this->belongsTo('App\Shipper', 'shipper_id', 'shipper_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedUser()
    {
        return $this->belongsTo('App\Driver', 'update_id');
    }
}
