<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Wheel extends BaseModel
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_wheel';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'tire_width',
        'aspect_ratio',
        'construction',
        'rim_diameter',
        'load_index',
        'speed_rating',
        'rim_width',
        'offset',
    ];    
}