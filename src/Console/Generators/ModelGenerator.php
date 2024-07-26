<?php

namespace Dmax\ClarityTools\Console\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ModelGenerator
{
    protected $name;

    public function __construct($name)
    {
        $this->name = ucfirst($name);
    }

    public function generate()
    {
        $this->generateDoaminModel();
        $this->generateEloquentModel();
    }

    private function generateDoaminModel(){
        // Determine the namespace
        $namespace = "App\\Domain\\{$this->name}";

        // Generate the service content
        $modelStub = File::get(__DIR__ . '/../../stubs/model.stub');
        $serviceContents = str_replace(['{{Namespace}}', '{{ClassName}}'], [$namespace, $this->name], $modelStub);

        // Determine the service file path
        $modelDirectory = app_path("Domain/{$this->name}/");
        $servicePath = $modelDirectory . "/{$this->name}.php";

        // Ensure the directory exists and write the contents to the file
        File::ensureDirectoryExists($modelDirectory);
        File::put($servicePath, $serviceContents);
    }

    private function generateEloquentModel(){
         // Determine the namespace
        $namespace = "App\\Infrastructure\\Database\\Models";

        // Generate the service content
        $modelStub = File::get(__DIR__ . '/../../stubs/model_eloquent.stub');
        $serviceContents = str_replace(['{{Namespace}}', '{{ClassName}}'], [$namespace, $this->name], $modelStub);

        // Determine the service file path
        $modelDirectory = app_path("Infrastructure/Database/Models");
        $servicePath = $modelDirectory . "/{$this->name}.php";

        // Ensure the directory exists and write the contents to the file
        File::ensureDirectoryExists($modelDirectory);
        File::put($servicePath, $serviceContents);
    }
}
