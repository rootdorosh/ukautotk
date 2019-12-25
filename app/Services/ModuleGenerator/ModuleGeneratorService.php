<?php

namespace App\Services\ModuleGenerator;

use Illuminate\Support\Str;
use Exception;
use App\Services\ModuleGenerator\Generators\Http\Requests\FormRequest;

/**
 * class ModuleGeneratorService
 */
class ModuleGeneratorService
{
    /*
     * @var string
     */
    private $module;
    
    /*
     * @var bool
     */
    private $force;
    
    /*
     * @var array
     */
    private $config;
    
    /*
     * ModuleGeneratorService constructor
     * 
     * @param string $module
     * @param bool $force
     * @return void
     */
    public function __construct(string $module, bool $force)
    {
        $this->module = $module;
        $this->force = $force;
    }
    
    /*
     * Run generator
     * 
     * @return void
     */
    public function run(): void
    {
        if (!is_file($this->getResourceFileConfig())) {
            throw new Exception("File {$this->getResourceFileConfig()} not found");
        }
        if (!is_dir($this->getResourcePathModels())) {
            throw new Exception("Directory {$this->getResourcePathModels()} not found");
        }
        
        $this->config['module'] = require $this->getResourceFileConfig();
        
        if (is_dir($this->getModulePath()) && !$this->force) {
            dd("Module {$this->config['module']['name']} already exists, run command with --force option");
        }        
        
        if (!is_dir($this->getModulePath())) {
            mkdir($this->getModulePath());
        }
        
        foreach ($this->getResourceFilesModels() as $modelFile) {
            $this->config['models'][] = require $this->getResourcePathModels() . $modelFile;
        }
        
        $this->generate();
    }
    
    /*
     * @return void
     */
    protected function generate(): void
    {
        $files = [];
        $models = [];
        foreach ($this->config['models'] as $modelConfig) {
            $models[] = $modelConfig['name'];
        }
        
        foreach ($this->config['models'] as $modelConfig) {
            $viewData = [
                'model' => $modelConfig,
                'models' => $models,
                'moduleName' => $this->config['module']['name'],
                'modelsData' => $this->config['models'],
            ];
            
            $this->putFileTest('/tests/Feature/Modules/' . $this->config['module']['name'] . '/Http/Controllers/' . $modelConfig['name'] . 'ControllerTest', 
                view()->file($this->getViewBasePath() . 'tests/api_crud.blade.php', $viewData)->render());
            
            $this->putFile('Http/Requests/' . $modelConfig['name'] . '/MetaRequest', view()->file($this->getViewBasePath() . 'http/requests/meta_request.blade.php', $viewData)->render());
            $this->putFile('Http/Requests/' . $modelConfig['name'] . '/IndexRequest', view()->file($this->getViewBasePath() . 'http/requests/index_request.blade.php', $viewData)->render());
            $this->putFile('Http/Requests/' . $modelConfig['name'] . '/FormRequest', view()->file($this->getViewBasePath() . 'http/requests/form_request.blade.php', $viewData)->render());
            $this->putFile('Http/Requests/' . $modelConfig['name'] . '/ShowRequest', view()->file($this->getViewBasePath() . 'http/requests/show_request.blade.php', $viewData)->render());
            $this->putFile('Http/Requests/' . $modelConfig['name'] . '/DestroyRequest', view()->file($this->getViewBasePath() . 'http/requests/destroy_request.blade.php', $viewData)->render());
            $this->putFile('Http/Controllers/' . $modelConfig['name'] . 'Controller', view()->file($this->getViewBasePath() . 'http/controller.blade.php', $viewData)->render());
            $this->putFile('Services/Crud/' . $modelConfig['name'] . 'CrudService', view()->file($this->getViewBasePath() . 'services/crud.blade.php', $viewData)->render());
            $this->putFile('Transformers/' . $modelConfig['name'] . 'Transformer', view()->file($this->getViewBasePath() . 'transformers/transformer.blade.php', $viewData)->render());
            $this->putFile('Models/' . $modelConfig['name'], view()->file($this->getViewBasePath() . 'models/model.blade.php', $viewData)->render());
            $this->putFile('Database/factories/' . $modelConfig['name'] . 'Factory', view()->file($this->getViewBasePath() . 'database/factory.blade.php', $viewData)->render());
            
            $migFile = 'Database/migrations/' . date('Y_m_d_H00'). $modelConfig['id'] . '_create_' . 
                Str::snake($this->config['module']['name']) . '_' . 
                Str::snake($modelConfig['name']) . '_table';
            
            $this->putFile($migFile, view()->file($this->getViewBasePath() . 'database/migration.blade.php', $viewData)->render());
           
            if (!empty($modelConfig['translatable'])) {
                $this->putFile('Transformers/Lang/' . $modelConfig['name'] . 'LangTransformer', view()->file($this->getViewBasePath() . 'transformers/lang_transformer.blade.php', $viewData)->render());
                $this->putFile('Models/Lang/' . $modelConfig['name'] . 'Lang', view()->file($this->getViewBasePath() . 'models/lang_model.blade.php', $viewData)->render());
                
                $this->putFile($migFile . '_lang', view()->file($this->getViewBasePath() . 'database/lang_migration.blade.php', $viewData)->render());
               
            }
        }
        
        $this->putFile('Config/permissions', view()->file($this->getViewBasePath() . 'config/permissions.blade.php', $viewData)->render());
        $this->putFile('Http/routes', view()->file($this->getViewBasePath() . 'http/routes.blade.php', $viewData)->render());
        foreach (config('translatable.locales') as $locale) {
            $this->putFile('Resources/Lang/' . $locale . '/model', view()->file($this->getViewBasePath() . 'resources/lang.blade.php', $viewData)->render());
        }
    }

    /*
     * @param string $file
     * @param string $content
     * @return void
     */
    protected function putFile(string $file, string $content): void
    {
        $content = "<?php \n\n" . $content;
        
        $path = $this->getModulePath();

        $folders = explode('/', $file);
        $file = array_pop($folders) . '.php';
        
        foreach ($folders as $folder) {
            $path .= $folder . DIRECTORY_SEPARATOR;
            if (!is_dir($path)) {
                mkdir($path, 0775);
            }
        }     
        
        $filePath = $path . $file;
        echo "$filePath \n";
        
        file_put_contents($filePath, $content);
    }

    /*
     * @param string $file
     * @param string $content
     * @return void
     */
    protected function putFileTest(string $file, string $content): void
    {
        $content = "<?php \n\n" . $content;
        
        $path = base_path() . '/';
        
        $folders = explode('/', $file);
        $file = array_pop($folders) . '.php';
        
        foreach ($folders as $folder) {
            if (empty($folder)) {
                continue;
            }
            $path .= $folder . DIRECTORY_SEPARATOR;
            if (!is_dir($path)) {
                mkdir($path, 0775);
            }
        }     
        
        $filePath = $path . $file;
        echo "$filePath \n";
        
        file_put_contents($filePath, $content);
    }

    /*
     * @return string
     */
    protected function getViewBasePath(): string
    {
        return app_path() . '/Services/ModuleGenerator/resources/views/';
    }

    /*
     * @return string
     */
    protected function getModulePath(): string
    {
        return app_path() . '/Modules/' . $this->config['module']['name'] . '/';
    }
    
    /*
     * @return string
     */
    protected function getResourcePath(): string
    {
        return resource_path() . '/modules/' . $this->module . '/';
    }
    
    /*
     * @return string
     */
    protected function getResourceFileConfig(): string
    {
        return $this->getResourcePath() . 'conf.php';
    }
    
    /*
     * @return string
     */
    protected function getResourcePathModels(): string
    {
        return $this->getResourcePath() . 'models/';
    }
    
    /*
     * @return array
     */
    protected function getResourceFilesModels(): array
    {
        $items = [];
        
        $skip = ['.', '..'];
        $files = scandir($this->getResourcePathModels());
        foreach ($files as $file) {
            if (!in_array($file, $skip) && is_file($this->getResourcePathModels() . $file)) {
                $items[] = $file;
            }
        }

        return $items;        
    }   
    
    //HELPERS
    /*
     * @param array $fields
     */
    public static function migration(array $fields)
    {
        $items = [];
        $items[] = '$table->increments(\'id\');';
        foreach ($fields as $attr => $field) {
            if(!empty($field['migration'])) {
                
                if ($field['migration']['type'] === 'enum') {
                    $row = '$table->' . $field['migration']['type'] . '(\'' . $attr . '\', ' . $field['migration']['value'] . ')';
                } else {
                    if (!empty($field['migration']['length'])) {
                        $row = '$table->' . $field['migration']['type'] . '(\'' . $attr .  '\', ' . $field['migration']['length'] . ')';
                    } else {
                        $row = '$table->' . $field['migration']['type'] . '(\'' . $attr . '\')';
                    }
                }
                
                if (!empty($field['migration']['nullable'])) {
                    $row.= '->nullable()';
                }
                if (!empty($field['migration']['default'])) {
                    $row.= '->default(\''. $field['migration']['default'] .'\')';
                }
                if (!empty($field['migration']['comment'])) {
                    $row.= '->comment(\''. $field['migration']['comment'] .'\')';
                }
                $row.= ';';
                $items[] = $row;
            } else {
                $items[] = '$table->' . $field['type'] . '(\'' . $attr . '\');';
            }
        } 
        
        $foreigns = [];
        
        foreach($fields as $attr => $field) {
            if(!empty($field['migration']['foreign'])) {
                $foreigns[] = '$table->foreign(\'' . $attr . '\')->references(\'id\')' . 
                    '->on(\'' . $field['migration']['foreign'][0] .'\')' . 
                    '->onDelete(\''. $field['migration']['foreign'][1] . '\');';        
            }
        }
        if (!empty($foreigns)) {
            $items[] = '';
            $items = array_merge($items, $foreigns);
        }
        
        $items = array_map(function($value){
            return "\t\t\t" . $value;
        }, $items);
        
        return implode("\n", $items);
    }
    
    /*
     * @param array $fields
     */
    public static function migration_lang(array $model)
    {
        $items = [
            '$table->increments(\'translation_id\');',
            '$table->integer(\'' . $model['translatable']['owner_id'] . '\')->unsigned();',
            '$table->char(\'locale\', 2)->index();',
        ];
        
        foreach($model['translatable']['fields'] as $attr => $field) {
            $items[] = '$table->' . $field['type'] . '(\'' . $attr . '\')->nullable();';
        }
        
        $items = array_map(function($value){
            return "\t\t\t" . $value;
        }, $items);
        
        return implode("\n", $items);
    }
    
    /*
     * @param array $model
     */
    public static function model_const(array $model)
    {
        if (empty($model['consts'])) {
            return '';
        }
        
        $items = [];
        
        foreach ($model['consts'] as $name => $data) {
            $items[] = '';
            foreach ($data['items'] as $i => $item) {
                $items[] = "\tCONST " . $name . '_' . strtoupper($item) . ' = ' . ($i+1) . ';';
            }
            $items[] = "\tCONST " . $data['plurar'] . ' = [';
            foreach ($data['items'] as $item) {
                $items[] = "\t\tself::" . $name . '_' . strtoupper($item) . ' => \'' . $item . '\',';
            }
            $items[] = "\t];";
            $items[] = '';
        }
        
        return implode("\n", $items);
    }
}
