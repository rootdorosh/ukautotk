<?php 
use Illuminate\Support\Str;
?>
declare( strict_types = 1 );

namespace App\Modules\{{ $moduleName }}\Services\Crud;

use App\Modules\{{ $moduleName }}\Models\{{ $model['name'] }};

/**
 * Class {{ $model['name'] }}CrudService
 */
class {{ $model['name'] }}CrudService
{
    /*
     * @param  array $data
     * @return {{ $model['name'] }}
     */
    public function store(array $data): {{ $model['name'] }}
    {
        ${{ Str::camel($model['name']) }} = {{ $model['name'] }}::create($data);
        
        return ${{ Str::camel($model['name']) }};
    }

    /*
     * @param  {{ $moduleName }} ${{ Str::camel($model['name']) }}
     * @param  {{ $model['name'] }} $data
     * @return {{ $model['name'] }}
     */
    public function update({{ $model['name'] }} ${{ Str::camel($model['name']) }}, array $data): {{ $model['name'] }}
    {
        ${{ Str::camel($model['name']) }}->update($data);
        
        return ${{ Str::camel($model['name']) }};
    }

    /*
     * @param  {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @return void
     */
    public function destroy({{ $model['name'] }} ${{ Str::camel($model['name']) }}): void
    {
        ${{ Str::camel($model['name']) }}->delete();
    }
    
}
