<?php

namespace Dmax\ClarityTools\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File; // Add this import
use Illuminate\Support\Str;
use Dmax\ClarityTools\Console\Generators\ControllerGenerator;
use Dmax\ClarityTools\Console\Generators\ExceptionGenerator;
use Dmax\ClarityTools\Console\Generators\ModelGenerator;
use Dmax\ClarityTools\Console\Generators\RepositoryGenerator;
use Dmax\ClarityTools\Console\Generators\RequestGenerator;
use Dmax\ClarityTools\Console\Generators\ServiceGenerator;

class GenerateFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:generate-files {name} {--api-version=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = ucwords(str_replace(' ', '', $this->argument('name')));
        $version = $this->option('api-version', null);

        (new ServiceGenerator($name))->generate();

        (new ModelGenerator($name))->generate();

        // // Generate Controllers
        (new ExceptionGenerator($name))->generate();

        // // Generate Controllers
        (new RepositoryGenerator($name))->generate();

        (new ControllerGenerator($name, $version))->generate();
        (new RequestGenerator($name))->generate();

        // create table
        $this->createTable();
    }


    private function createTable()
    {

        $tableName = Str::plural(strtolower($this->argument('name')));

        if (!$tableName) {
            $this->error('Please provide the table name using --table option.');
            return;
        }

        $migrationClassName = 'Create' . Str::studly($tableName) . 'Table';

        $this->call('make:migration', [
            'name' => $migrationClassName
        ]);
    }
}
