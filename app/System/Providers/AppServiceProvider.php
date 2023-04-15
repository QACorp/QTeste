<?php

namespace App\System\Providers;

use App\System\Component\DeleteModal;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('delete-modal', DeleteModal::class);
        $this->addDirectoryMigration();

    }

    private function addDirectoryMigration(){
        $mainPath = database_path('migrations');
        $directories = glob(app_path('Modules') . '/*/Migrations' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        $this->loadMigrationsFrom($paths);
    }
}
