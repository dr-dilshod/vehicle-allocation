<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
 * @property User $user
 * @property User $updateUser
 * @property Billing[] $billings
 * @property Payment[] $payments
 */
class Vehicle extends Model
{
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
    protected $fillable = ['create_id', 'update_id', 'vehicle_no', 'company_name', 'company_kana_name', 'vehicle_company_abbreviation', 'vehicle_postal_code', 'vehicle_address1', 'vehicle_address2', 'vehicle_phone_number', 'vehicle_fax_number', 'offset', 'vehicle_remark', 'delete_flg', 'created_at', 'updated_at'];

    /**
     * @var array
     */
    public static $createValidationRules = [
        'vehicle_no' => 'required|unique:vehicles|max:4',
        'company_name' => 'required|max:191',
        'company_kana_name' => 'max:191',
        'vehicle_company_abbreviation' => 'max:191',
        'vehicle_postal_code' => 'max:191',
        'vehicle_address1' => 'max:191',
        'vehicle_address2' => 'max:191',
        'vehicle_phone_number' => 'max:15',
        'vehicle_fax_number' => 'max:15',
        'vehicle_offset' => 'min:0|max:1',
        'delete_flg' => 'min:0|max:1',
    ];

    /**
     * @var array
     */
    public static $editValidationRules = [
        'vehicle_no' => 'required|max:4',
        'company_name' => 'required|max:191',
        'company_kana_name' => 'max:191',
        'vehicle_company_abbreviation' => 'max:191',
        'vehicle_postal_code' => 'max:191',
        'vehicle_address1' => 'max:191',
        'vehicle_address2' => 'max:191',
        'vehicle_phone_number' => 'max:15',
        'vehicle_fax_number' => 'max:15',
        'vehicle_offset' => 'min:0|max:1',
        'delete_flg' => 'min:0|max:1',
    ];

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
        return $this->hasMany('App\Billing', null, 'vehicle_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Payment', null, 'vehicle_id');
    }
}
