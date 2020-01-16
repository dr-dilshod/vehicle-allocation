<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $shipper_id
 * @property integer $create_id
 * @property integer $update_id
 * @property string $shipper_no
 * @property string $shipper_name1
 * @property string $shipper_name2
 * @property string $shipper_kana_name1
 * @property string $shipper_kana_name2
 * @property string $shipper_company_abbreviation
 * @property string $postal_code
 * @property string $address1
 * @property string $address2
 * @property string $phone_number
 * @property string $fax_number
 * @property boolean $closing_date
 * @property string $payment_date
 * @property boolean $delete_flg
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 * @property User $updateUser
 * @property Billing[] $billings
 * @property Item[] $items
 * @property Payment[] $payments
 * @property UnitPrice[] $unitPrices
 */
class Shipper extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'shipper_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['create_id', 'update_id', 'shipper_no', 'shipper_name1', 'shipper_name2', 'shipper_kana_name1', 'shipper_kana_name2', 'shipper_company_abbreviation', 'postal_code', 'address1', 'address2', 'phone_number', 'fax_number', 'closing_date', 'payment_date', 'delete_flg', 'created_at', 'updated_at'];

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
    public function updateUser()
    {
        return $this->belongsTo('App\User', 'update_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function billings()
    {
        return $this->hasMany('App\Billing', null, 'shipper_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Item', null, 'shipper_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Payment', null, 'shipper_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unitPrices()
    {
        return $this->hasMany('App\UnitPrice', null, 'shipper_id');
    }
}
