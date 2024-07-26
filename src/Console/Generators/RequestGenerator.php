<?php

namespace Dmax\ClarityTools\Console\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RequestGenerator
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function generate()
    {
        $this->storeRequest();
        $this->updateRequest();
        $this->deleteRequest();
    }

    public function storeRequest()
    {
        $action = 'Create';
        // Determine the namespace
        $namespace = 'App\\Presenter\\Http\\' . $this->name . '\\' . $action;

        // Determine the class name based on the action
        $className = ucfirst($action) . $this->name . 'Request';

        // Read the content of the stub file
        $requestStub = File::get(__DIR__ . '/../../stubs/requests/request_store.stub');

        // Replace placeholders with actual content
        $requestContents = str_replace(
            ['{{ClassName}}', '{{Namespace}}'],
            [$className, $namespace],
            $requestStub
        );

        // Determine the request file path
        $requestDirectory = app_path("Presenter/Http/{$this->name}/{$action}");
        $requestPath = $requestDirectory . "/{$className}.php";

        // Ensure the directory exists and write the contents to the file
        File::ensureDirectoryExists($requestDirectory);
        File::put($requestPath, $requestContents);
    }

    public function updateRequest()
    {
        $action = 'Update';
        // Determine the namespace
        $namespace = 'App\\Presenter\\Http\\' . $this->name . '\\' . $action;

        // Determine the class name based on the action
        $className = ucfirst($action) . $this->name . 'Request';

        // Read the content of the stub file
        $requestStub = File::get(__DIR__ . '/../../stubs/requests/request_update.stub');

        // Replace placeholders with actual content
        $requestContents = str_replace(
            ['{{ClassName}}', '{{Namespace}}'],
            [$className, $namespace],
            $requestStub
        );

        // Determine the request file path
        $requestDirectory = app_path("Presenter/Http/{$this->name}/{$action}");
        $requestPath = $requestDirectory . "/{$className}.php";

        // Ensure the directory exists and write the contents to the file
        File::ensureDirectoryExists($requestDirectory);
        File::put($requestPath, $requestContents);
    }

    public function deleteRequest()
    {
        $action = 'Delete';
        // Determine the namespace
        $namespace = 'App\\Presenter\\Http\\' . $this->name . '\\' . $action;

        // Determine the class name based on the action
        $className = ucfirst($action) . $this->name . 'Request';

        // Read the content of the stub file
        $requestStub = File::get(__DIR__ . '/../../stubs/requests/request_delete.stub');

        // Replace placeholders with actual content
        $requestContents = str_replace(
            ['{{ClassName}}', '{{Namespace}}'],
            [$className, $namespace],
            $requestStub
        );

        // Determine the request file path
        $requestDirectory = app_path("Presenter/Http/{$this->name}/{$action}");
        $requestPath = $requestDirectory . "/{$className}.php";

        // Ensure the directory exists and write the contents to the file
        File::ensureDirectoryExists($requestDirectory);
        File::put($requestPath, $requestContents);
    }
}
