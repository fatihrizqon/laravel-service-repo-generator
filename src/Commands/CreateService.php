<?php

namespace Fatihrizqon\ServiceRepoGenerator\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateService extends GeneratorCommand
{
    protected $name = 'create:service';
    protected $description = 'Create a new service and service interface';
    protected $type = 'Service';

    protected function getStub()
    {
        return __DIR__ . '/../../stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . 'Services';
    }

    public function handle()
    {
        parent::handle();
        $this->createServiceInterface();
    }

    protected function createServiceInterface()
    {
        $name = $this->argument('name');
        $interfaceName = 'I' . $name;

        $namespace = 'Services\\Interfaces';
        $namespacePath = $this->getNamespacePath($namespace);
        $path = $namespacePath . DIRECTORY_SEPARATOR . $interfaceName . '.php';

        if (file_exists($path)) {
            $this->error("Interface $interfaceName already exists!");
            return;
        }

        if (!is_dir($namespacePath)) {
            mkdir($namespacePath, 0755, true);
        }

        $stub = file_get_contents(__DIR__ . '/../../stubs/service-interface.stub');

        $rootNamespace = $this->laravel->getNamespace();
        $fullNamespace = $rootNamespace . $namespace;

        $stub = str_replace(['{{ namespace }}', '{{ class }}'], [$fullNamespace, $interfaceName], $stub);

        file_put_contents($path, $stub);

        $this->info("Service Interface created successfully: $path");
    }

    protected function getNamespacePath($namespace)
    {
        $rootNamespace = $this->laravel->getNamespace();
        $relativePath = str_replace('\\', '/', $namespace);
        return app_path($relativePath);
    }
}
