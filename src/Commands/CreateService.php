<?php

namespace Fatihrizqon\ServiceRepoGenerator\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateService extends GeneratorCommand
{
    protected $signature = 'create:service {name}';
    protected $description = 'Create a new service and service interface';
    protected $type = 'Service';

    protected function getStub()
    {
        return __DIR__.'/../../stubs/service.stub';
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Services';
    }

    public function handle()
    {
        parent::handle();
        $this->createServiceInterface();
    }

    protected function createServiceInterface()
    {
        $name = $this->argument('name').'Service';
        $interfaceName = 'I'.$name;

        $path = app_path('Services/Interfaces');
        $file = $path.'/'.$interfaceName.'Service.php';

        if (file_exists($file)) {
            $this->error("Interface {$interfaceName} already exists!");
            return;
        }

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $stub = file_get_contents(__DIR__.'/../../stubs/service-interface.stub');

        $stub = str_replace(
            ['{{ namespace }}', '{{ class }}'],
            [$this->laravel->getNamespace().'Services\\Interfaces', $interfaceName],
            $stub
        );

        file_put_contents($file, $stub);

        $this->info("Service Interface created: {$file}");
    }
}
