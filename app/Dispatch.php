<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $dispatch_id
 * @property integer $driver_id
 * @property integer $item_id
 * @property integer $create_id
 * @property integer $update_id
 * @property boolean $timezone
 * @property boolean $delete_flg
 * @property string $created_at
 * @property string $updated_at
 * @property Driver $driver
 * @property Item $item
 * @property Driver $createdUser
 * @property Driver $updatedUser
 */
class Dispatch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dispatch';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'dispatch_id';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['driver_id', 'item_id', 'create_id', 'update_id', 'timezone', 'delete_flg', 'created_at', 'updated_at'];

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
    public function driver()
    {
        return $this->belongsTo('App\Driver', null, 'driver_id');
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
    public function updatedUser()
    {
        return $this->belongsTo('App\Driver', 'update_id');
    }
}
