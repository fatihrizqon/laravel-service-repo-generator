<?php

namespace Fatihrizqon\ServiceRepoGenerator;

use Illuminate\Support\ServiceProvider;
use Fatihrizqon\ServiceRepoGenerator\Commands\CreateService;
use Fatihrizqon\ServiceRepoGenerator\Commands\CreateRepository;

class ServiceRepoGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/service-repo-generator.php',
            'service-repo-generator'
        );
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateService::class,
                CreateRepository::class,
            ]);

            $this->publishes([
                __DIR__.'/../stubs' => base_path('stubs/service-repo-generator'),
            ], 'service-repo-stubs');

            $this->publishes([
                __DIR__.'/../config/service-repo-generator.php' => config_path('service-repo-generator.php'),
            ], 'service-repo-config');
        }
    }
}
