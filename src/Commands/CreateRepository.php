<?php

namespace Fatihrizqon\ServiceRepoGenerator\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateRepository extends GeneratorCommand
{
    protected $signature = 'create:repository {name}';
    protected $description = 'Create a new repository and repository interface';
    protected $type = 'Repository';

    protected function getStub()
    {
        return __DIR__.'/../../stubs/repository.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Repositories';
    }

    public function handle()
    {
        parent::handle();
        $this->createRepositoryInterface();
    }

    protected function createRepositoryInterface()
    {
        $name = $this->argument('name');
        $interfaceName = 'I'.$name;

        $path = app_path('Repositories/Interfaces');
        $file = $path.'/'.$interfaceName.'.php';

        if (file_exists($file)) {
            $this->error("Interface {$interfaceName} already exists!");
            return;
        }

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $stub = file_get_contents(__DIR__.'/../../stubs/repository-interface.stub');

        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}'],
            [$this->laravel->getNamespace().'Repositories\\Interfaces', $interfaceName],
            $stub
        );

        file_put_contents($file, $stub);

        $this->info("Repository Interface created: {$file}");
    }
}
