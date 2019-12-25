<?php 
use Illuminate\Support\Str;
?>
declare( strict_types = 1 );

namespace App\Modules\{{ $moduleName }}\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Modules\{{ $moduleName }}\Services\Crud\{{ $model['name'] }}CrudService;
use App\Services\Response\FractalManager;
@if (!empty($model['translatable']))
use App\Base\ExtArrHelper;
@endif
use App\Modules\{{ $moduleName }}\Models\{{ $model['name'] }};
use App\Modules\{{ $moduleName }}\Transformers\{{ $model['name'] }}Transformer;
use App\Modules\{{ $moduleName }}\Http\Requests\{{ $model['name'] }}\{
    MetaRequest,
    IndexRequest,
    FormRequest,
    ShowRequest,
    DestroyRequest
};

/**
 * @group {{ strtoupper(Str::snake($moduleName)) }}
 */
class {{ $model['name'] }}Controller extends Controller
{
    /*
     * var {{ $model['name'] }}CrudService
     */
    protected $crudService;
    
    /*
     * var FractalManager
     */
    protected $fractalManager;

    /*
     * @var {{ $model['name'] }}Transformer
     */
    private $transformer;
    
    /*
     * @param FractalManager            $fractalManager
     * @param {{ $model['name'] }}CrudService           $crudService
     * @param {{ $model['name'] }}Transformer           $transformer
     */
    public function __construct(
        FractalManager $fractalManager, 
        {{ $model['name'] }}CrudService $crudService,
        {{ $model['name'] }}Transformer $transformer
    )
    {
        $this->fractalManager = $fractalManager;
        $this->crudService = $crudService;
        $this->transformer = $transformer;
    }
    
    /**
     * {{ $model['name_plural'] }} meta
     *
     * @authenticated
     * 
     * @responseFile 200 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/meta/200.json
     * 
     * @param MetaRequest $request
     * @return  JsonResponse
     */
    public function meta(MetaRequest $request): JsonResponse
    {
        return response()->json([
            'labels' => __('{{ Str::camel($moduleName) }}::model.{{ Str::camel($model['name']) }}'),
        ]);
    }

    /**
     * {{ $model['name_plural'] }} list
     *
     * @authenticated
     * 
     * @responseFile 200 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/index/200.json
     * @responseFile 422 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/index/422.json
     * 
     * @param   IndexRequest $request
     * @return  JsonResponse
     */
    public function index(IndexRequest $request): JsonResponse
    {
        return response()->json($this->fractalManager->collectionToFractalPaginate(
            $request,
            $request->paginate(),
            $this->transformer
        ));
    }

    /**
     * {{ $model['name_plural'] }} store
     *
     * @authenticated
     * 
     * @responseFile 201 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/store/201.json
     * @responseFile 422 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/store/422.json
     * 
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function store(FormRequest $request): JsonResponse
    {
        ${{ Str::camel($model['name']) }} = $this->crudService->store($request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item(${{ Str::camel($model['name']) }}, $this->transformer->setItemIncludes())
        );
@if (!empty($model['translatable']))        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);@else
        return response()->json($data, 201);@endif            
    }

    /**
     * {{ $model['name_plural'] }} update
     *
     * @authenticated
     * 
     * @responseFile 200 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/update/200.json
     * @responseFile 422 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/update/422.json
     * @responseFile 404 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/update/404.json
     * 
     * @param   {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @param   FormRequest $request
     * @return  JsonResponse
     */
    public function update({{ $model['name'] }} ${{ Str::camel($model['name']) }}, FormRequest $request): JsonResponse
    {
        ${{ Str::camel($model['name']) }} = $this->crudService->update(${{ Str::camel($model['name']) }}, $request->validated());
        
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item(${{ Str::camel($model['name']) }}, $this->transformer->setItemIncludes())
        );
@if (!empty($model['translatable']))        
        return response()->json(ExtArrHelper::transformModelLang($data), 201);@else
        return response()->json($data, 201);@endif            
    }

    /**
     * {{ $model['name_plural'] }} show
     *
     * @authenticated
     * 
     * @responseFile 200 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/show/200.json
     * @responseFile 422 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/show/404.json
     * 
     * @param   ShowRequest $request
     * @param   {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @return  JsonResponse
     */
    public function show({{ $model['name'] }} ${{ Str::camel($model['name']) }}, ShowRequest $request): JsonResponse
    {
        $data = $this->fractalManager->formatResourceFractal(
            fractal()->item(${{ Str::camel($model['name']) }}, $this->transformer->setItemIncludes())
        );
@if (!empty($model['translatable']))        
        return response()->json(ExtArrHelper::transformModelLang($data), 200);@else
        return response()->json($data, 200);@endif            
    }

    /**
     * {{ $model['name_plural'] }} destroy
     *
     * @authenticated
     * 
     * @responseFile 204 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/destroy/204.json
     * @responseFile 422 responses/{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/destroy/404.json
     * 
     * @param   DestroyRequest $request
     * @param   {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @return  JsonResponse
     */
    public function destroy({{ $model['name'] }} ${{ Str::camel($model['name']) }}, DestroyRequest $request): JsonResponse
    {
        $this->crudService->destroy(${{ Str::camel($model['name']) }});
        return response()->json(null, 204);
    }
}