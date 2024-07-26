<?php

namespace Dmax\ClarityTools;

use Illuminate\Support\ServiceProvider;

class CleanblueprintServiceProvider extends ServiceProvider {


    public function boot(){
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Commands\GenerateFiles::class,
            ]);
        }
        $this->publishes([
            __DIR__.'/config/clean-architecture.php' => config_path('clean-architecture.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/clean-architecture.php', 'clean-architecture');
    }

}
