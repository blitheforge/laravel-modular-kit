<?php

namespace Mahadi\LaravelModuleMaker\Console\Commands;

use Illuminate\Console\Command;

class MakeModuleController extends Command
{
    protected $signature = 'make:module-controller {module} {name}';
    protected $description = 'Generate a controller inside a module';

    public function handle()
    {
        return $this->call('make:module:resource', [
            'module' => $this->argument('module'),
            'type'   => 'controller',
            'name'   => $this->argument('name'),
        ]);
    }
}
