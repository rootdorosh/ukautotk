<?php 
use Illuminate\Support\Str;
$fields = $model['fields'];
if (!empty($model['translatable'])) {
    $fields = $fields + $model['translatable']['fields'];
}

$tab5 = "                    ";
$tab4 = "                ";
$tab3 = "            ";
$tab2 = "        ";
$sortAttrIn = '';
$rules = '';

$defaultIncludes = '';
$availableIncludes = '';
$itemIncludes = '';

foreach ($fields as $key => $item):
    if (isset($item['filter']) && $item['filter']): 
        $defaultIncludes .= "\n{$tab2}'{$key}',";
    endif;
    $availableIncludes .= "\n{$tab2}'{$key}',";
endforeach;

foreach ($fields as $key => $item):
    $itemIncludes .= "\n{$tab2}'{$key}',";
endforeach;
if (!empty($model['translatable'])):
    $itemIncludes .= "\n{$tab2}'lang',";
endif;
$rules .= $tab3;


?>
declare( strict_types = 1 );

namespace App\Modules\{{ $moduleName }}\Transformers;

use App\Modules\{{ $moduleName }}\Models\{{ $model['name'] }};
use App\Base\AbstractTransformer;
@if (!empty($model['translatable']))
use App\Modules\{{ $moduleName }}\Transformers\Lang\{{ $model['name'] }}LangTransformer;
@endif

/**
 * Class {{ $model['name'] }}Transformer.
 */
class {{ $model['name'] }}Transformer extends AbstractTransformer
{
    /**
     * default includes
     *
     * @var array
     */
    protected $defaultIncludes = [{!! $defaultIncludes !!}
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [{!! $availableIncludes !!}
    ];

    /**
     * List of item resource to include
     *
     * @var array
     */
    public $itemIncludes = [{!! $itemIncludes !!}
    ];

    /**
     * transform
     *
     * @param {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @return array
     */
    public function transform({{ $model['name'] }} ${{ Str::camel($model['name']) }}) : array
    {
        return [
            'id' => ${{ Str::camel($model['name']) }}->id,
        ];
    }    
<?php foreach ($fields as $attr => $item):?>    
    /**
     * Include <?= $attr . "\n"?>
     *
     * @return \League\Fractal\Resource\Item
     */
    public function include<?= ucfirst(Str::camel($attr))?>({{ $model['name'] }} ${{ Str::camel($model['name']) }})
    {
        return $this->primitive(${{ Str::camel($model['name']) }}-><?= $attr?>);
    }
<?php endforeach ?>

    @if (!empty($model['translatable']))
/**
     * Include lang
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeLang({{ $model['name'] }} ${{ Str::camel($model['name']) }})
    {
        return $this->collection(${{ Str::camel($model['name']) }}->translations, new {{ $model['name'] }}LangTransformer);
    }
    @endif
}
