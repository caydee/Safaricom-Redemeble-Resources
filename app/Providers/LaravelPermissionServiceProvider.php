<?php
namespace App\Providers;
use App\Http\Middleware\AuthRoles;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use App\Commands\PermissionsClear;
use App\Commands\PermissionsGenerate;

class LaravelPermissionServiceProvider extends ServiceProvider {
    public function boot(Router $router)
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                PermissionsGenerate::class,
                PermissionsClear::class,
            ]);
        }

        $router->aliasMiddleware('auth.role', AuthRoles::class);
    }
    public function register()
    {
    }
}
?>
