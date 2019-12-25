<?php 
use Illuminate\Support\Str
?>

Route::name('{{ Str::kebab($moduleName) }}.')
    ->namespace('\App\Modules\{{ $moduleName }}\Http\Controllers')
    ->prefix('scms/{{ Str::kebab($moduleName) }}')
    ->middleware('auth:api')
    ->group(function () {
    <?php foreach ($modelsData as $model):?>    
        Route::get('<?= $model['routes']['path']?>/meta', '<?= $model['name']?>Controller@meta')->name('<?= Str::kebab($model['name_plural'])?>.meta');
        @if(isset($model['routes']['update_verb']) && $model['routes']['update_verb'] === 'POST')
Route::post('<?= $model['routes']['path']?>/{{{ Str::camel($model['name']) }}}', '<?= $model['name']?>Controller@update')->name('<?= Str::kebab($model['name_plural'])?>.update');
        Route::apiResource('<?= $model['routes']['path']?>', '<?= $model['name']?>Controller')->except('update');
        @else
Route::apiResource('<?= $model['routes']['path']?>', '<?= $model['name']?>Controller');
        @endif
    <?php endforeach?>
        
});