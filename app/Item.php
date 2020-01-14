<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Item
 * @package App
 * @author  Dilshod K
 */
class Item extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'items';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'item_id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['shipper_id', 'driver_id', 'vehicle_no', 'status',
        'stack_date', 'stack_time', 'down_date', 'down_time', 'down_invoice',
        'stack_point', 'down_point', 'weight', 'empty_pl', 'item_price',
        'item_driver_name', 'vehicle_no3', 'shipper_name', 'item_vehicle', 'vehicle_payment',
        'item_completion_date', 'item_remark', 'delete_flg', 'create_id',
        'created_at', 'update_id', 'updated_at', 'remember_token'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $user = Auth::user();
            if (!empty($user)) {
                $model->create_id = $user->id;
                $model->update_id = $user->id;
            }
        });
        static::updating(function ($model) {
            $user = Auth::user();
            if (!empty($user))
                $model->update_id = $user->id;
        });
    }
}
