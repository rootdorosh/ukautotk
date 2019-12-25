<?php

namespace App\Modules\Auto\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\Translatable\Translatable;

class Market extends Model
{
    use Translatable;
    
    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'auto_market';
    
    /**
     * @var  bool
     */
    public $timestamps = false;
	    
    /**
     * @var  string
     */
	public $translationForeignKey = 'market_id';	

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
        'abbr',
    ];
}
