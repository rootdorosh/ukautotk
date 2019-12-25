<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class ThreadSize extends BaseModel
{
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_thread_size';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'title',
    ];
}
