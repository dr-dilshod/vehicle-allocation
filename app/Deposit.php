<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * @property integer $deposit_id
 * @property integer $shipper_id
 * @property Date deposit_day
 * @property int $deposit_amount
 * @property int other
 * @property int $fee
 * @property boolean $delete_flg
 * @property integer $create_id
 * @property string $created_at
 * @property integer $update_id
 * @property string $updated_at
 * @property Shipper $shipper
 * @property Driver $createdUser
 * @property Driver $updatedUser
 */
class Deposit extends Model
{
    use BlameableTrait;

    const validationRules = [
        'shipper_id' => 'required',
    ];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'deposit_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['shipper_id', 'deposit_day', 'deposit_amount', 'other', 'fee', 'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at'];

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
