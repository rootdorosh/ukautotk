<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class TrimWheel extends BaseModel
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_trim_wheel';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'trim_id',
        'front_id',
        'rear_id',
        'is_stock',
        'front_pressure',
        'rear_pressure',
    ];    
}