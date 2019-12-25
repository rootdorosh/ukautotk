<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Trim extends BaseModel
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_trim';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'model_year_id',
        'vehicle_id',
        'title',
        'generation_id',
        'market_id',
        'engine_id',
        'thread_size_id',
        'is_active',
        'slug',
        'options',
        'power_hp',
        'power_kw',
        'power_ps',
        'torque',
        'center_bore',
        'wheel_fasteners',
        'trim_production',
    ];
}