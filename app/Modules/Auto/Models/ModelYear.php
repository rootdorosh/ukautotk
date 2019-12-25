<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class ModelYear extends BaseModel
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_model_year';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'is_active',
        'year',
        'model_id',
    ];
}
