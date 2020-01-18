<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $deposit_id
 * @property integer $invoice_id
 * @property integer $create_id
 * @property integer $update_id
 * @property int $deposit_amount
 * @property int $fee
 * @property string $deposit_remark
 * @property boolean $delete_flg
 * @property string $created_at
 * @property string $updated_at
 * @property Invoice $billing
 * @property User $user
 * @property User $updateUser
 */
class Deposit extends Model
{
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
    protected $fillable = ['invoice_id', 'create_id', 'update_id', 'deposit_amount', 'fee', 'deposit_remark', 'delete_flg', 'created_at', 'updated_at'];

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
    public function updateUser()
    {
        return $this->belongsTo('App\User', 'update_id');
    }
}
