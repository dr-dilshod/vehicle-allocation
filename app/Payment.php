<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $payment_id
 * @property integer $invoice_id
 * @property integer $vehicle_id
 * @property integer $shipper_id
 * @property integer $create_id
 * @property integer $update_id
 * @property int $shipper_deposit
 * @property int $shipper_highway
 * @property int $vehicle_deposit
 * @property int $vehicle_highway
 * @property boolean $delete_flg
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice $billing
 * @property Shipper $shipper
 * @property User $user
 * @property User $updateUser
 * @property Vehicle $vehicle
 */
class Payment extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'payment_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['invoice_id', 'vehicle_id', 'shipper_id', 'create_id', 'update_id', 'shipper_deposit', 'shipper_highway', 'vehicle_deposit', 'vehicle_highway', 'delete_flg', 'created_at', 'updated_at'];

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
    public function billing()
    {
        return $this->belongsTo('App\Invoice', 'invoice_id', 'invoice_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle', null, 'vehicle_id');
    }
}
