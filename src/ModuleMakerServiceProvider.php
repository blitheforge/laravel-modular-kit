<?php

namespace Mahadi\LaravelModuleMaker;

use Illuminate\Support\ServiceProvider;
use Mahadi\LaravelModuleMaker\Console\Commands\MakeModule;
use Mahadi\LaravelModuleMaker\Console\Commands\MakeModuleResource;
use Mahadi\LaravelModuleMaker\Console\Commands\MakeModuleController;
use Mahadi\LaravelModuleMaker\Console\Commands\MakeModuleModel;
use Mahadi\LaravelModuleMaker\Console\Commands\MakeModuleMigration;
use Mahadi\LaravelModuleMaker\Console\Commands\MakeModuleRoute;

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
