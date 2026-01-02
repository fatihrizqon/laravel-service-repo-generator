<?php

namespace Fatihrizqon\ServiceRepoGenerator\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateRepository extends GeneratorCommand
{
    protected $name = 'create:repository';
    protected $description = 'Create a new repository and repository interface';
    protected $type = 'Repository';

    /**
     * Path ke stub package
     */
    protected function getStub()
    {
        return __DIR__ . '/../../stubs/repository.stub';
    }

    /**
     * Default namespace for repository
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . 'Repositories';
    }

    public function handle()
    {
        parent::handle();
        $this->createRepositoryInterface();
    }

    protected function createRepositoryInterface()
    {
        $name = $this->argument('name');
        $interfaceName = 'I' . $name;

        $namespace = 'Repositories\\Interfaces';
        $namespacePath = $this->getNamespacePath($namespace);

        $path = $namespacePath . DIRECTORY_SEPARATOR . $interfaceName . '.php';

        if (file_exists($path)) {
            $this->error("Interface $interfaceName already exists!");
            return;
        }

        if (!is_dir($namespacePath)) {
            mkdir($namespacePath, 0755, true);
        }

        $stub = file_get_contents(__DIR__ . '/../../stubs/repository-interface.stub');

        $rootNamespace = $this->laravel->getNamespace();
        $fullNamespace = $rootNamespace . $namespace;

        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}'],
            [$fullNamespace, $interfaceName],
            $stub
        );

        file_put_contents($path, $stub);

        $this->info("Repository Interface created successfully: $path");
    }

    protected function getNamespacePath($namespace)
    {
        $rootNamespace = $this->laravel->getNamespace();
        $relativePath = str_replace('\\', '/', $namespace);
        return app_path($relativePath);
    }
}
