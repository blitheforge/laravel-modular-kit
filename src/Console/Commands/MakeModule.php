<?php

namespace Blitheforge\LaravelModuleMaker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModule extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Create a new module with full structure';

    public function handle()
    {
        $moduleName = ucfirst($this->argument('name'));
        $basePath = base_path('Modules/' . $moduleName);

        if (File::exists($basePath)) {
            $this->error("Module already exists!");
            return 1;
        }

        $folders = [
            'Controllers',
            'Models',
            'Views',
            'Routes',
            'Services',
            'Repositories',
            'Helpers',
            'Requests',
            'Database/Migrations',
            'Database/Seeders',
            'Providers'
        ];

        foreach ($folders as $folder) {
            File::makeDirectory($basePath . '/' . $folder, 0755, true, true);
        }

        File::put($basePath . '/Controllers/' . $moduleName . 'Controller.php', "<?php

namespace Modules\\{$moduleName}\\Controllers;

use App\\Http\\Controllers\\Controller;

class {$moduleName}Controller extends Controller
{
    public function index()
    {
        return '{$moduleName} module working';
    }
}");

        File::put($basePath . '/Routes/web.php', "<?php

use Illuminate\\Support\\Facades\\Route;
use Modules\\{$moduleName}\\Controllers\\{$moduleName}Controller;

Route::get('/" . strtolower($moduleName) . "', [{$moduleName}Controller::class, 'index']);
");

        File::put($basePath . '/Models/' . $moduleName . '.php', "<?php

namespace Modules\\{$moduleName}\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class {$moduleName} extends Model
{
    protected \$guarded = [];
}");

        File::put($basePath . '/Database/Migrations/create_' . strtolower($moduleName) . '_table.php', "<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('" . strtolower($moduleName) . "', function (Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('" . strtolower($moduleName) . "');
    }
};");

        File::put($basePath . '/Database/Seeders/' . $moduleName . 'Seeder.php', "<?php

namespace Modules\\{$moduleName}\\Database\\Seeders;

use Illuminate\\Database\\Seeder;

class {$moduleName}Seeder extends Seeder
{
    public function run()
    {
        //
    }
}");

        File::put($basePath . '/Providers/' . $moduleName . 'ServiceProvider.php', "<?php

namespace Modules\\{$moduleName}\\Providers;

use Illuminate\\Support\\ServiceProvider;
use Illuminate\\Support\\Facades\\Route;
use Illuminate\\Support\\Facades\\View;

class {$moduleName}ServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        \$this->loadRoutes();
        \$this->loadViews();
        \$this->loadMigrations();
        \$this->loadHelpers();
    }

    protected function loadRoutes()
    {
        \$web = __DIR__ . '/../Routes/web.php';

        if (file_exists(\$web)) {
            Route::middleware('web')->group(\$web);
        }
    }

    protected function loadViews()
    {
        \$path = __DIR__ . '/../Views';

        if (is_dir(\$path)) {
            View::addNamespace('{$moduleName}', \$path);
        }
    }

    protected function loadMigrations()
    {
        \$path = __DIR__ . '/../Database/Migrations';

        if (is_dir(\$path)) {
            \$this->loadMigrationsFrom(\$path);
        }
    }

    protected function loadHelpers()
    {
        \$path = __DIR__ . '/../Helpers';

        if (is_dir(\$path)) {
            foreach (glob(\$path . '/*.php') as \$file) {
                require_once \$file;
            }
        }
    }
}");

        $this->info("Module {$moduleName} created successfully.");

        return 0;
    }
}
