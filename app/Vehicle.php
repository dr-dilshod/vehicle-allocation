<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use RichanFongdasen\EloquentBlameable\BlameableTrait;

/**
 * @property integer $vehicle_id
 * @property integer $create_id
 * @property integer $update_id
 * @property string $vehicle_no
 * @property string $company_name
 * @property string $company_kana_name
 * @property string $vehicle_company_abbreviation
 * @property string $vehicle_postal_code
 * @property string $vehicle_address1
 * @property string $vehicle_address2
 * @property string $vehicle_phone_number
 * @property string $vehicle_fax_number
 * @property boolean $offset
 * @property string $vehicle_remark
 * @property boolean $delete_flg
 * @property string $created_at
 * @property string $updated_at
 * @property Driver $createdUser
 * @property Driver $updatedUser
 * @property Invoice[] $invoices
 * @property Payment[] $payments
 */
class Vehicle extends Model
{
    use BlameableTrait;

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'vehicle_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['create_id', 'update_id', 'vehicle_no', 'company_name',
        'company_kana_name', 'vehicle_company_abbreviation', 'vehicle_postal_code',
        'vehicle_address1', 'vehicle_address2', 'vehicle_phone_number', 'vehicle_fax_number',
        'offset', 'vehicle_remark', 'delete_flg', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    const validationRules = [
        'addedVehicles.*.vehicle_no' => 'required|max:4',
        'addedVehicles.*.company_name' => 'required|max:60',
        'addedVehicles.*.company_kana_name' => 'max:60',
        'addedVehicles.*.vehicle_company_abbreviation' => 'max:60',
        'addedVehicles.*.vehicle_postal_code' => 'max:8',
        'addedVehicles.*.vehicle_address1' => 'max:120',
        'addedVehicles.*.vehicle_address2' => 'max:120',
        'addedVehicles.*.offset' => '',
        'addedVehicles.*.vehicle_phone_number' => 'max:13',
        'addedVehicles.*.vehicle_fax_number' => 'max:12',
        'addedVehicles.*.vehicle_remark' => 'max:255',
    ];

    const updateRules = [
        'updatedVehicles.*.vehicle_no' => 'required|max:4',
        'updatedVehicles.*.company_name' => 'required|max:60',
        'updatedVehicles.*.company_kana_name' => 'max:60',
        'updatedVehicles.*.vehicle_company_abbreviation' => 'max:60',
        'updatedVehicles.*.vehicle_postal_code' => 'max:8',
        'updatedVehicles.*.vehicle_address1' => 'max:120',
        'updatedVehicles.*.vehicle_address2' => 'max:120',
        'updatedVehicles.*.offset' => '',
        'updatedVehicles.*.vehicle_phone_number' => 'max:13',
        'updatedVehicles.*.vehicle_fax_number' => 'max:12',
        'updatedVehicles.*.vehicle_remark' => 'max:255',
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
    public function updatedUser()
    {
        return $this->belongsTo('App\Driver', 'update_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Invoice', null, 'vehicle_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Payment', null, 'vehicle_id');
    }
}
