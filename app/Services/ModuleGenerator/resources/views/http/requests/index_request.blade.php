<?php 
use Illuminate\Support\Str;
$fields = $model['fields'];
if (!empty($model['translatable'])) {
    $fields = $fields + $model['translatable']['fields'];
}
?>declare( strict_types = 1 );

namespace App\Modules\{{ $moduleName }}\Http\Requests\{{ $model['name'] }};

use Illuminate\Database\Eloquent\Builder;
use App\Base\Requests\BaseIndexRequest;
use App\Modules\{{ $moduleName }}\Models\{{ $model['name'] }};

/**
 * Class IndexRequest
 * 
 * @package App\Modules\{{ $moduleName }}
 *
 * @bodyParam page             integer  optional page
 * @bodyParam per_page         integer  optional per page
 * @bodyParam sort_dir         string   optional sorting dir
 * @bodyParam sort_attr        string   optional sorting attribute
 * @bodyParam id               integer  optional id
@foreach ($model['fields'] as $key => $item)
@if (isset($item['filter']) && $item['filter'])
 * @bodyParam {{$key}}  {{$item['type']}}   optional    {{$item['label']}}
@endif
@endforeach
@if (!empty($model['translatable']))
@foreach ($model['translatable']['fields'] as $key => $item)
@if (isset($item['filter']) && $item['filter'])
 * @bodyParam {{$key}}  {{$item['type']}}   optional    {{$item['label']}}
@endif
@endforeach
@endif;

 */
class IndexRequest extends BaseIndexRequest
{
    /*
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->hasPermission('{{ strtolower($moduleName) }}.{{ strtolower($model['name']) }}.index');
    }
    <?php 
        $tab5 = "                    ";
        $tab4 = "                ";
        $tab3 = "            ";
        $tab2 = "        ";
        $sortAttrIn = '';
        $rules = '';

        foreach ($fields as $key => $item):
            if (isset($item['filter']) && $item['filter']): 
                $sortAttrIn .= "\n{$tab5}'{$key}',";
                $rules .= "{$tab3}'{$key}' => [\n";
                $rules .= "{$tab4}'nullable',\n";
                $rules .= "{$tab4}'{$item['type']}',\n";
                $rules .= "{$tab3}],\n";
            endif;
        endforeach;
        $rules .= $tab3;
    ?>
    
    /*
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules() + [
            'sort_attr' => [
                'nullable',
                'string',
                'in:' . implode(',', [{!! $sortAttrIn !!}
                ]),
            ],
{!! $rules !!}'id' => [
                'nullable',
                'integer',
                'min:1',
            ],
        ];
        
        return $rules;
    }
        
    /*
     * @return array
     */
    public function attributes(): array
    {
        return $this->getAttributesLabels('{{ $moduleName }}', '{{ $model['name'] }}') + parent::attributes();
    }
    
    /*
     * @return Builder
     */
    public function getQueryBuilder() : Builder
    {
<?php 
$query = '';
if (!empty($model['translatable'])) {
    $query = '$query = ' . $model['name'] . '::select([' . "\n";
    $query.= "{$tab3}'{$model['table']}.*',\n";
    foreach ($model['translatable']['fields'] as $key => $item):
        if (isset($item['filter']) && $item['filter']):
            $query .= "{$tab3}'{$model['table']}_lang.{$key} AS {$key}',\n";
        endif;
    endforeach;
    $query.= "{$tab2}])\n";
    $query.= "{$tab2}->leftJoin('{$model['table']}_lang', '{$model['table']}_lang.{$model['translatable']['owner_id']}', '{$model['table']}.id')\n";
    $query.= "{$tab2}->where('{$model['table']}_lang.locale', app()->getLocale());\n";
    
} else {
    $query = '$query = ' . $model['name'] . '::query();';
}

$queryWhere =  "\n{$tab2}" . 'if ($this->id !== null) {' . "\n";
$queryWhere.= $tab3 . '$query->where("id", "like", "%{$this->id}%");' . "\n";
$queryWhere.= $tab2 . '}' . "\n";

foreach ($fields as $key => $item):
    if (isset($item['filter']) && $item['filter']):    
        $queryWhere.=  "\n{$tab2}" . 'if ($this->' . $key . ' !== null) {' . "\n";
        $queryWhere.= $tab3 . '$query->where("' . $key . '", "like", "%{$this->' . $key . '}%");' . "\n";
        $queryWhere.= $tab2 . '}' . "\n";
    endif;
endforeach;

?>{{ $tab2 }}{!! $query !!}{!! $queryWhere !!}        
        return $query;
    }

}