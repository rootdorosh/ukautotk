<?php 

declare( strict_types = 1 );

namespace App\Modules\Auto\Models\Lang;

use Illuminate\Database\Eloquent\Model;

class ModelLang extends Model
{
    /**
     * primary key.
     *
     * @var  string
     */
    protected $primaryKey = 'translation_id';
       
    /**
     * table name.
     *
     * @var  string
     */
    protected $table = 'auto_model_lang';

    /**
     * @var  bool
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     
     * @var  array
     */
    public $fillable = [
        'is_translated',
        'title',
    ];
}
