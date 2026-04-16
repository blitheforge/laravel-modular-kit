<?php

namespace Sohoj\LaravelModuleMaker;

use Illuminate\Support\ServiceProvider;
use Sohoj\LaravelModuleMaker\Console\Commands\MakeModule;
use Sohoj\LaravelModuleMaker\Console\Commands\MakeModuleResource;
use Sohoj\LaravelModuleMaker\Console\Commands\MakeModuleController;
use Sohoj\LaravelModuleMaker\Console\Commands\MakeModuleModel;
use Sohoj\LaravelModuleMaker\Console\Commands\MakeModuleMigration;
use Sohoj\LaravelModuleMaker\Console\Commands\MakeModuleRoute;

class ModuleMakerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->commands([
            MakeModule::class,
            MakeModuleResource::class,
            MakeModuleController::class,
            MakeModuleModel::class,
            MakeModuleMigration::class,
            MakeModuleRoute::class,
        ]);
    }
}
