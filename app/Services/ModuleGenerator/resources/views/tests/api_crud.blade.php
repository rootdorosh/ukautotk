<?php 
use Illuminate\Support\Str;
$updateVerb = $model['routes']['update_verb'] ?? 'PUT';
?>
namespace Tests\Feature\Modules\{{ $moduleName }}\Http\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use App\Modules\{{ $moduleName }}\Models\{{ $model['name'] }};
@if (!empty($model['translatable']))
use App\Base\ExtArrHelper;
@endif

/**
 * Class {{ $model['name'] }}ControllerTest
 * 
 * @group {{ Str::camel($moduleName) }}
 */
class {{ $model['name'] }}ControllerTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;
     
    /*
     * @param {{ $model['name'] }} ${{ Str::camel($model['name']) }}
     * @return array
     */
    private function toArray({{ $model['name'] }} ${{ Str::camel($model['name']) }}): array
    {
            @if (!empty($model['translatable']))
return ExtArrHelper::keyToItems(${{ Str::camel($model['name']) }}->toArray(), 'translations', 'locale'); 
            @else
return ${{ Str::camel($model['name']) }}->toArray();    
            @endif
    }
    
    /**
     * @test
     */
    public function meta()
    {
        $url = self::BASE_URL . '{{ Str::kebab($moduleName) }}/{{ Str::kebab($model['routes']['path']) }}/meta';
      
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/meta', 200);   
    }

    /**
     * @test
     */
    public function index()
    {
        $url = self::BASE_URL . '{{ Str::kebab($moduleName) }}/{{ Str::kebab($model['routes']['path']) }}';
        
        factory({{ $model['name'] }}::class, 3)->create();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/index', 200);   
        
        $response = $this->json('GET', $url, ['page' => '-', 'per_page' => '-'], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/index', 422);        
    }
    
    /**
     * @test
     */
    public function store()
    {
        $url = self::BASE_URL . '{{ Str::kebab($moduleName) }}/{{ Str::kebab($model['routes']['path']) }}';
      
        $response = $this->json('POST', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/store', 422);   
        
        $data = $this->toArray(factory({{ $model['name'] }}::class)->make());
        
        $response = $this->json('POST', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/store', 201);        
    }
    
    /**
     * @test
     */
    public function update()
    {       
        ${{ Str::camel($model['name']) }} = factory({{ $model['name'] }}::class)->create();
        $url = self::BASE_URL . '{{ Str::kebab($moduleName) }}/{{ Str::kebab($model['routes']['path']) }}/' . ${{ Str::camel($model['name']) }}->id;
        $data = $this->toArray(${{ Str::camel($model['name']) }});
        
        $response = $this->json('{{ $updateVerb }}', $url, [], self::$headers);
        $response->assertStatus(422);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/update', 422);   
        
        $response = $this->json('{{ $updateVerb }}', $url, $data, self::$headers);
        $response->assertStatus(201);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/update', 200); 
        
        ${{ Str::camel($model['name']) }}->delete();
        
        $response = $this->json('{{ $updateVerb }}', $url, $data, self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/update', 404);        
    }
    
    /**
     * @test
     */
    public function show()
    {       
        ${{ Str::camel($model['name']) }} = factory({{ $model['name'] }}::class)->create();
        $url = self::BASE_URL . '{{ Str::kebab($moduleName) }}/{{ Str::kebab($model['routes']['path']) }}/' . ${{ Str::camel($model['name']) }}->id;
               
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(200);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/show', 200); 
        
        ${{ Str::camel($model['name']) }}->delete();
        
        $response = $this->json('GET', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/show', 404);        
    }
    
    /**
     * @test
     */
    public function destroy()
    {       
        ${{ Str::camel($model['name']) }} = factory({{ $model['name'] }}::class)->create();
        $url = self::BASE_URL . '{{ Str::kebab($moduleName) }}/{{ Str::kebab($model['routes']['path']) }}/' . ${{ Str::camel($model['name']) }}->id;
               
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(204);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/destroy', 204); 
        
        ${{ Str::camel($model['name']) }}->delete();
        
        $response = $this->json('DELETE', $url, [], self::$headers);
        $response->assertStatus(404);        
        $this->saveResponse($response, '{{ Str::snake($moduleName) }}/{{ strtolower(Str::snake($model['name_plural'])) }}/destroy', 404);        
    }
}
