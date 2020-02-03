<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * @property integer $driver_id
 * @property integer $create_id
 * @property integer $update_id
 * @property integer $payment_id
 * @property integer $shipper_id
 * @property boolean $delete_flg
 * @property string $created_at
 * @property string $updated_at
 * @property Shipper $shipper
 * @property Driver $createdUser
 * @property Driver $updatedUser
 */
class Payment extends Model
{
    use BlameableTrait;
    const validationRules = [];
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
    protected $fillable = [ 'shipper_id','payment_day','payment_amount','other','fee', 'delete_flg', 'create_id', 'update_id', 'created_at', 'updated_at'];

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shipper()
    {
        return $this->belongsTo('App\Shipper', null, 'shipper_id');
    }

}
