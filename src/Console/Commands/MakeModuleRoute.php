<?php

namespace Mahadi\LaravelModuleMaker\Console\Commands;

use Illuminate\Console\Command;

class MakeModuleRoute extends Command
{
    protected $signature = 'make:module-route {module} {name}';
    protected $description = 'Generate a route inside a module';

    public function handle()
    {
        return $this->call('make:module:resource', [
            'module' => $this->argument('module'),
            'type'   => 'route',
            'name'   => $this->argument('name'),
        ]);
    }
}
