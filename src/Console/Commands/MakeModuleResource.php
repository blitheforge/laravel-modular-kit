<?php

namespace Blitheforge\LaravelModuleMaker\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleResource extends Command
{
    protected $signature = 'make:module:resource {module} {type} {name}';
    protected $description = 'Create module resources (controller, model, migration, route)';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $type   = strtolower($this->argument('type'));
        $name   = $this->argument('name');

        $basePath = base_path("Modules/{$module}");

        if (!File::exists($basePath)) {
            $this->error("Module [{$module}] does not exist. Create it first using make:module");
            return 1;
        }

        return match ($type) {
            'controller' => $this->makeController($module, $name),
            'model'      => $this->makeModel($module, $name),
            'migration'  => $this->makeMigration($module, $name),
            'route'      => $this->makeRoute($module, $name),
            default      => $this->error("Unknown type: {$type}"),
        };
    }

    private function makeController(string $module, string $name)
    {
        $path = base_path("Modules/{$module}/Controllers/{$name}.php");

        File::put($path, "<?php

namespace Modules\\{$module}\\Controllers;

use App\\Http\\Controllers\\Controller;

class {$name} extends Controller
{
    public function index()
    {
        return '{$name} in {$module} working';
    }
}");

        $this->info("Controller created: Modules/{$module}/Controllers/{$name}.php");
        return 0;
    }

    private function makeModel(string $module, string $name)
    {
        $path = base_path("Modules/{$module}/Models/{$name}.php");

        File::put($path, "<?php

namespace Modules\\{$module}\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class {$name} extends Model
{
    protected \$guarded = [];
}");

        $this->info("Model created: Modules/{$module}/Models/{$name}.php");
        return 0;
    }

    private function makeMigration(string $module, string $name)
    {
        $file = date('Y_m_d_His') . "_{$name}.php";
        $path = base_path("Modules/{$module}/Database/Migrations/{$file}");

        File::put($path, "<?php

use Illuminate\\Database\\Migrations\\Migration;
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Support\\Facades\\Schema;

return new class extends Migration {
    public function up()
    {
        //
    }

    public function down()
    {
        //
    }
};");

        $this->info("Migration created: Modules/{$module}/Database/Migrations/{$file}");
        return 0;
    }

    private function makeRoute(string $module, string $name)
    {
        $path = base_path("Modules/{$module}/Routes/web.php");

        File::append($path, "

use Illuminate\\Support\\Facades\\Route;

Route::get('/{$name}', function () {
    return '{$module} route: {$name}';
});
");

        $this->info("Route added to Modules/{$module}/Routes/web.php");
        return 0;
    }
}
