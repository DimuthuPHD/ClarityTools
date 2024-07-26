<?php

namespace Dmax\ClarityTools\Console\Generators;

use Illuminate\Support\Facades\File;

class ExceptionGenerator
{
    protected $name;

    public function __construct($name)
    {
        $this->name = ucfirst($name);
    }

    public function generate()
    {


        // This script checks whether the parent exception class exists in the application directory. If it doesn't, it copies it from the package directory.
        $packageDirectory = __DIR__ . '/../../Domain/EntityNotFound.php';
        $destinationDirectory = app_path('Domain');

        // Check if the file already exists in the application directory
        if (!File::exists($destinationDirectory . '/EntityNotFound.php')) {
            // Copy the file from the package to the application directory
            File::copy($packageDirectory, $destinationDirectory . '/EntityNotFound.php');

            echo "EntityNotFound class copied successfully.\n";
        } else {
            echo "EntityNotFound class already exists in the application directory.\n";
        }


        // Determine the namespace
        $namespace = "App\\Domain\\{$this->name}";

        // Generate the service content
        $exceptionStub = File::get(__DIR__ . '/../../stubs/not_found.stub');
        $exceptionContents = str_replace(
            ["{{Namespace}}", "{{name}}"],
            [$namespace, "{$this->name}"],
            $exceptionStub
        );

        // Determine the service file path
        $serviceDirectory = app_path("Domain/{$this->name}");
        $servicePath = "{$serviceDirectory}/{$this->name}NotFound.php";

        // Ensure the directory exists and write the contents to the file
        File::ensureDirectoryExists($serviceDirectory);
        File::put($servicePath, $exceptionContents);
    }
}
