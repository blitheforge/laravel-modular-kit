<?php

namespace Blitheforge\LaravelModuleMaker\Console\Commands;

use Illuminate\Console\Command;

class MakeModuleMigration extends Command
{
    protected $signature = 'make:module-migration {module} {name}';
    protected $description = 'Generate a migration inside a module';

    public function handle()
    {
        return $this->call('make:module:resource', [
            'module' => $this->argument('module'),
            'type'   => 'migration',
            'name'   => $this->argument('name'),
        ]);
    }
}
