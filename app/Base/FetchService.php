<?php

namespace App\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FetchService
 */
class FetchService
{
    /*
     * @var string
     */
    protected $tag;

    /*
     * @var Model
     */
    protected $model;
    
    /*
     * construct
     */
    public function __construct()
    {
        $modelNamespace = str_replace(
            ['Services\Fetch', 'FetchService'],
            ['Models', ''],
            static::class
        );
        
        $this->model = new $modelNamespace;
        
        $this->tag = $this->model->getTag();
    }

}