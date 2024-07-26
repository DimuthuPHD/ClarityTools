<?php

namespace Dmax\ClarityTools\Console\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ControllerGenerator
{
    protected $name;
    protected $version;

    public function __construct($name, $version = null)
    {
        $this->name = ucfirst($name);
        $this->version = $version;
    }

    public function generate()
    {

        $this->storeController();
        $this->updateController();
        $this->deleteController();
        $this->loadController();

        if($this->version){
            $this->generateRouteFile();
        }
    }


    private function storeController(){

         // Controllers
         $action = 'Create';
        $namespace = 'App\\Presenter\\Http\\' . $this->name. '\\' . $action;

        $controllerStub = File::get(__DIR__ . '/../../stubs/controllers/controller_store.stub');
        $controllerPath = app_path("Presenter/Http/{$this->name}/{$action}/{$action}{$this->name}Controller.php");
        $serviceNameCamelCase = Str::camel($this->name) . 'Service';
        $serviceAction = strtolower($action).ucfirst($this->name);
        $className = "{$action}{$this->name}Controller";
        $controllerContents = str_replace(
            ['{{ClassName}}', '{{Namespace}}', '{{ Request }}', '{{ ServiceName }}', '{{ serviceNameCamelCase }}', '{{ serviceAction }}'],
            [$className, $namespace, "{$action}{$this->name}Request", $this->name . 'Service', $serviceNameCamelCase, $serviceAction],
            $controllerStub
        );
        File::ensureDirectoryExists(dirname($controllerPath));
        File::put($controllerPath, $controllerContents);

    }

    private function updateController(){
         // Controllers
         $action = "Update";
        $namespace = 'App\\Presenter\\Http\\' . $this->name. '\\' . $action;

        $controllerStub = File::get(__DIR__ . '/../../stubs/controllers/controller_update.stub');
        $controllerPath = app_path("Presenter/Http/{$this->name}/{$action}/{$action}{$this->name}Controller.php");
        $serviceNameCamelCase = Str::camel($this->name) . 'Service';
        $serviceAction = strtolower($action).ucfirst($this->name);
        $className = "{$action}{$this->name}Controller";
        $controllerContents = str_replace(
            ['{{ClassName}}', '{{Namespace}}', '{{ Request }}', '{{ ServiceName }}', '{{ serviceNameCamelCase }}', '{{ serviceAction }}'],
            [$className, $namespace, "{$action}{$this->name}Request", $this->name . 'Service', $serviceNameCamelCase, $serviceAction],
            $controllerStub
        );
        File::ensureDirectoryExists(dirname($controllerPath));
        File::put($controllerPath, $controllerContents);
    }

    private function deleteController(){
         // Controllers
         $action = 'Delete';
        $namespace = 'App\\Presenter\\Http\\' . $this->name. '\\' . $action;

        $controllerStub = File::get(__DIR__ . '/../../stubs/controllers/controller_delete.stub');
        $controllerPath = app_path("Presenter/Http/{$this->name}/{$action}/{$action}{$this->name}Controller.php");
        $serviceNameCamelCase = Str::camel($this->name) . 'Service';
        $serviceAction = strtolower($action).ucfirst($this->name);
        $className = "{$action}{$this->name}Controller";
        $controllerContents = str_replace(
            ['{{ClassName}}', '{{Namespace}}', '{{ Request }}', '{{ ServiceName }}', '{{ serviceNameCamelCase }}', '{{ serviceAction }}'],
            [$className, $namespace, "{$action}{$this->name}Request", $this->name . 'Service', $serviceNameCamelCase, $serviceAction],
            $controllerStub
        );
        File::ensureDirectoryExists(dirname($controllerPath));
        File::put($controllerPath, $controllerContents);
    }

    private function loadController(){
         // Controllers
        $action = 'Load';
        $namespace = 'App\\Presenter\\Http\\' . $this->name. '\\' . $action;

        $controllerStub = File::get(__DIR__ . '/../../stubs/controllers/controller_load.stub');
        $controllerPath = app_path("Presenter/Http/{$this->name}/{$action}/{$action}{$this->name}Controller.php");
        $serviceNameCamelCase = Str::camel($this->name) . 'Service';
        $serviceAction = strtolower($action).ucfirst($this->name);
        $className = "{$action}{$this->name}Controller";
        $controllerContents = str_replace(
            ['{{ClassName}}', '{{Namespace}}', '{{ ServiceName }}', '{{ serviceNameCamelCase }}', '{{ serviceAction }}'],
            [$className, $namespace, $this->name . 'Service', $serviceNameCamelCase, $serviceAction],
            $controllerStub
        );
        File::ensureDirectoryExists(dirname($controllerPath));
        File::put($controllerPath, $controllerContents);
    }

    private function generateRouteFile(){


        $importControllers  = "use App\\Presenter\\Http\\{$this->name}\\Create\\Create{$this->name}Controller;\n";
        $importControllers .="use App\\Presenter\\Http\\{$this->name}\\Delete\\Delete{$this->name}Controller;\n";
        $importControllers .="use App\\Presenter\\Http\\{$this->name}\\Update\\Update{$this->name}Controller;\n";
        $importControllers .="use App\\Presenter\\Http\\{$this->name}\\Load\\Load{$this->name}Controller;\n";

        $routeId = strtolower($this->name).'Id';
        $routeActions  = "Route::post('', Create{$this->name}Controller::class);\n";
        $routeActions .= "Route::get('/{{$routeId}}', Load{$this->name}Controller::class);\n";
        $routeActions .= "Route::post('{{$routeId}}/update', Update{$this->name}Controller::class);\n";
        $routeActions .= "Route::delete('{{$routeId}}/delete', Delete{$this->name}Controller::class);\n";

        $version = 'v'.$this->version;
        $file_name = strtolower($this->name);
        $prefix = strtolower($this->name);
        $routeStub = File::get(__DIR__ . '/../../stubs/route.stub');
        $routePath = app_path("Presenter/Http/Routes/{$version}/{$file_name}.php");

        $controllerContents = str_replace(
            ['{{Imports}}', '{{routeActions}}', '{{prefix}}'],
            [$importControllers, $routeActions, $prefix],
            $routeStub
        );
        File::ensureDirectoryExists(dirname($routePath));
        File::put($routePath, $controllerContents);
    }
}
