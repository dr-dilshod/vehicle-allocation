<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

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
 * @property Invoice $invoice
 * @property Driver $createdUser
 * @property Driver $updatedUser
 */
class Deposit extends Model
{
//    use BlameableTrait;

    const validationRules = [
        'invoice_id' => 'required',
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
    protected $fillable = ['invoice_id', 'create_id', 'update_id', 'deposit_amount', 'fee', 'deposit_remark', 'delete_flg', 'created_at', 'updated_at'];

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
    public function invoice()
    {
        return $this->belongsTo('App\Invoice', 'invoice_id', 'invoice_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedUser()
    {
        return $this->belongsTo('App\Driver', 'update_id');
    }
}
