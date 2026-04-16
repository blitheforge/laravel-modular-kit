<?php

namespace Blitheforge\LaravelModuleMaker;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Blitheforge\LaravelModuleMaker\Console\Commands\MakeModule;
use Blitheforge\LaravelModuleMaker\Console\Commands\MakeModuleResource;
use Blitheforge\LaravelModuleMaker\Console\Commands\MakeModuleController;
use Blitheforge\LaravelModuleMaker\Console\Commands\MakeModuleModel;
use Blitheforge\LaravelModuleMaker\Console\Commands\MakeModuleMigration;
use Blitheforge\LaravelModuleMaker\Console\Commands\MakeModuleRoute;

class ModuleMakerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerModuleNamespace();
        $this->registerModules();

        $this->commands([
            MakeModule::class,
            MakeModuleResource::class,
            MakeModuleController::class,
            MakeModuleModel::class,
            MakeModuleMigration::class,
            MakeModuleRoute::class,
        ]);
    }

    protected function registerModuleNamespace(): void
    {
        $modulesPath = base_path('Modules');

        if (! File::exists($modulesPath)) {
            return;
        }

        $loader = $this->getComposerClassLoader();

        if (! $loader) {
            return;
        }

        $loader->addPsr4('Modules\\', [$modulesPath . '/']);
    }

    protected function getComposerClassLoader(): ?ClassLoader
    {
        foreach (spl_autoload_functions() ?? [] as $autoload) {
            if (is_array($autoload) && $autoload[0] instanceof ClassLoader) {
                return $autoload[0];
            }
        }

        return null;
    }

    protected function registerModules(): void
    {
        $modulesPath = base_path('Modules');

        if (! File::exists($modulesPath)) {
            return;
        }

        foreach (File::directories($modulesPath) as $modulePath) {
            $moduleName = basename($modulePath);
            $provider = "Modules\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider";
            $providerFile = $modulePath . '/Providers/' . $moduleName . 'ServiceProvider.php';

            if (! class_exists($provider) && file_exists($providerFile)) {
                require_once $providerFile;
            }

            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }
}
