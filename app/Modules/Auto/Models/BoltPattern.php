<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class BoltPattern extends BaseModel
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_bolt_pattern';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'stud',
        'pcd',
    ];
}
