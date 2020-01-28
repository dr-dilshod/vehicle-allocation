<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * @property integer $invoice_id
 * @property integer $item_id
 * @property integer $shipper_id
 * @property integer $vehicle_id
 * @property integer $create_id
 * @property integer $update_id
 * @property string $billing_recording_date
 * @property string $billing_deadline_date
 * @property string $payment_record_date
 * @property string $invoice_remark
 * @property boolean $delete_flg
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property Item $item
 * @property Shipper $shipper
 * @property Driver $createdUser
 * @property Driver $updatedUser
 * @property Vehicle $vehicle
 * @property Deposit[] $deposits
 * @property Payment[] $payments
 */
class Invoice extends Model
{
    use BlameableTrait;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'invoice_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['item_id', 'shipper_id', 'vehicle_id', 'create_id', 'update_id', 'billing_recording_date', 'billing_deadline_date', 'payment_record_date', 'invoice_remark', 'delete_flg', 'remember_token', 'created_at', 'updated_at'];

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
    public function item()
    {
        return $this->belongsTo('App\Item', null, 'item_id');
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle', null, 'vehicle_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function deposits()
    {
        return $this->hasMany('App\Deposit', 'invoice_id', 'invoice_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Payment', 'invoice_id', 'invoice_id');
    }
}
