<?php

namespace Dmax\ClarityTools\Console\Generators;

use Illuminate\Support\Facades\File;

class RepositoryGenerator
{
    protected $name;

    public function __construct($name)
    {
        $this->name = ucfirst($name);
    }

    public function generate()
    {
        $this->generateInterface();
        $this->generateRepository();
        $this->bindRepos();
    }


    private function generateRepository(){
         // Determine the namespace
         $namespace = 'App\\Infrastructure\\Repositories';

         // Generate the repository content
         $repositoryStub = File::get(__DIR__ . '/../../stubs/repository.stub');
         $repositoryContents = str_replace(
             ['{{Namespace}}', '{{ClassName}}', '{{ModelName}}', '{{modelNameVariable}}'],
             ["{$namespace}", "{$this->name}Repository", "{$this->name}", strtolower($this->name)],
             $repositoryStub
         );

         // Determine the repository file path
         $repositoryDirectory = app_path("Infrastructure/Repositories");
         $repositoryPath = "{$repositoryDirectory}/{$this->name}Repository.php";

         // Ensure the directory exists and write the contents to the file
         File::ensureDirectoryExists($repositoryDirectory);
         File::put($repositoryPath, $repositoryContents);
    }

    private function generateInterface(){
        // Determine the namespace
       $namespace =  "App\\Domain\\{$this->name}";
       $className =  "{$this->name}RepositoryInterface";

       // Generate the service content
       $modelStub = File::get(__DIR__ . '/../../stubs/repository_interface.stub');
       $serviceContents = str_replace(['{{Namespace}}', '{{ClassName}}', '{{ModelName}}'], [$namespace, $className, $this->name], $modelStub);

       // Determine the service file path
       $modelDirectory = app_path("Domain/{$this->name}");
       $servicePath = $modelDirectory . "/{$className}.php";

       // Ensure the directory exists and write the contents to the file
       File::ensureDirectoryExists($modelDirectory);
       File::put($servicePath, $serviceContents);

   }

   private function bindRepos(){
         // Bind repos
         // Retrieve interface and class names from RepositoryGenerator
         $repositoryInterface = "App\Domain\\{$this->name}\\{$this->name}RepositoryInterface";
         $repositoryClass = "App\Infrastructure\Repositories\\{$this->name}Repository";

         // Bind the interface to the repository
         app()->bind($repositoryInterface, $repositoryClass);
   }
}
