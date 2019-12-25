<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Translatable\Translatable;

class Generation extends Model
{
    use Translatable;
    
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_generation';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	    
    /**
     * @var  string
     */
	public $translationForeignKey = 'generation_id';	

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
        'model_id',
        'd_slug',
        'is_active',
        'year_from',
        'year_to',
    ];
}
