<?php

namespace Mahadi\LaravelModuleMaker\Console\Commands;

use Illuminate\Console\Command;

class MakeModuleModel extends Command
{
    protected $signature = 'make:module-model {module} {name}';
    protected $description = 'Generate a model inside a module';

    public function handle()
    {
        return $this->call('make:module:resource', [
            'module' => $this->argument('module'),
            'type'   => 'model',
            'name'   => $this->argument('name'),
        ]);
    }
}
