<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UnitPrice
 * @package App
 * @property integer $price_id
 * @property integer $shipper_id
 * @property integer $item_id
 * @property integer $driver_id
 * @property integer $type
 * @property integer $price
 * @property integer $delete_flg
 * @property integer $created_id
 * @property integer $created_at
 * @property integer $updated_id
 * @property integer $updated_at
 */
class UnitPrice extends Model
{
    public static $createValidationRules = [
        'shipper_id' => 'bail|required|exists:shippers,id|numeric',
        'item_id' => 'bail|required|exists:items,item_id|numeric',
        'driver_id' => 'bail|required|exists:drivers,driver_id|numeric',
        'type' => 'bail|required|numeric',
        'price' => 'bail|required|numeric',
    ];

    public static $updateValidationRules = [
        'shipper_id' => 'bail|required|exists:shippers,id|numeric',
        'item_id' => 'bail|required|exists:items,item_id|numeric',
        'driver_id' => 'bail|required|exists:drivers,driver_id|numeric',
        'type' => 'bail|required|numeric',
        'price' => 'bail|required|numeric',
    ];

    protected $primaryKey = 'price_id';

    protected $fillable = ['shipper_id', 'item_id', 'driver_id', 'type', 'price'];

    protected $hidden = ['delete_flg'];

    public function shipper() {
        return $this->belongsTo('App\Shipper', 'shipper_id', 'id');
    }

    public function item() {
        return $this->belongsTo('App\Item', 'item_id');
    }

    public function driver() {
        return $this->belongsTo('App\Driver', 'driver_id');
    }
}
