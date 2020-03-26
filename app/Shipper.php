<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

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
 * @property Driver $createdUser
 * @property Driver $updatedUser
 * @property Invoice[] $invoices
 * @property Item[] $items
 * @property Payment[] $payments
 * @property UnitPrice[] $unitPrices
 */
class Shipper extends Model
{
    use BlameableTrait;
    const validationRules = [
        'addedShippers.*.shipper_no' => 'required|max:4',
        'addedShippers.*.shipper_name1' => 'required|max:60',
        'addedShippers.*.shipper_name2' => 'max:60',
        'addedShippers.*.shipper_kana_name1' => 'max:60',
        'addedShippers.*.shipper_kana_name2' => 'max:60',
        'addedShippers.*.shipper_company_abbreviation' => 'max:60',
        'addedShippers.*.postal_code' => 'max:8',
        'addedShippers.*.address1' => 'max:120',
        'addedShippers.*.address2' => 'max:120',
        'addedShippers.*.phone_number' => 'max:12',
        'addedShippers.*.fax_number' => 'max:12'
    ];

    const updateRules = [
        'updatedShippers.*.shipper_no' => 'required|max:4',
        'updatedShippers.*.shipper_name1' => 'required|max:60',
        'updatedShippers.*.shipper_name2' => 'max:60',
        'updatedShippers.*.shipper_kana_name1' => 'max:60',
        'updatedShippers.*.shipper_kana_name2' => 'max:60',
        'updatedShippers.*.shipper_company_abbreviation' => 'max:60',
        'updatedShippers.*.postal_code' => 'max:8',
        'updatedShippers.*.address1' => 'max:120',
        'updatedShippers.*.address2' => 'max:120',
        'updatedShippers.*.phone_number' => 'max:12',
        'updatedShippers.*.fax_number' => 'max:12'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shippers';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'shipper_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['shipper_no', 'shipper_name1', 'shipper_name2', 'shipper_kana_name1', 'shipper_kana_name2', 'shipper_company_abbreviation', 'postal_code',
        'address1', 'address2', 'phone_number', 'fax_number', 'closing_date', 'payment_date', 'delete_flg', 'create_id', 'created_at', 'update_id', 'updated_at'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Invoice', null, 'shipper_id');
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
