<?php

namespace Dmax\ClarityTools\Console\Generators;

use Illuminate\Support\Facades\File;

class ServiceGenerator
{
    protected $name;

    public function __construct($name)
    {
        $this->name = ucfirst($name);
    }

    public function generate()
    {
        // Determine the namespace
        $namespace = "App\\Application\\Services";

        // Generate the service content
        $serviceStub = File::get(__DIR__ . '/../../stubs/service.stub');
        $serviceContents = str_replace(
            ["{{Namespace}}", "{{DomainClassImportPath}}", "{{DomainClass}}", "{{ClassName}}", "{{RepositoryInterface}}"],
            [$namespace, "{$this->name}\\{$this->name}",$this->name, $this->name, "$this->name\\{$this->name}RepositoryInterface"],
            $serviceStub
        );

        // Determine the service file path
        $serviceDirectory = app_path("Application/Services");
        $servicePath = "{$serviceDirectory}/{$this->name}Service.php";

        // Ensure the directory exists and write the contents to the file
        File::ensureDirectoryExists($serviceDirectory);
        File::put($servicePath, $serviceContents);
    }
}
