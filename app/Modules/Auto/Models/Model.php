<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;
use App\Services\Translatable\Translatable;

class Model extends BaseModel
{
    use Translatable;
    
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_model';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	
    /**
     * @var  string
     */
	public $translationForeignKey = 'model_id';	

    /*
     * @var  array
     */
    public $translatedAttributes = [
        'is_translated',
        'title',
    ];

    /*
     * @var  array
     */
    protected $with = ['translations'];
        
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'is_active',
        'slug',
        'make_id',
    ];
}
