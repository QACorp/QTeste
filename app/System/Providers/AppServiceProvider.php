<?php

namespace App\System\Providers;

use App\System\Business\UserBusiness;
use App\System\Component\DeleteModal;
use App\System\Config\MenuConfig;
use App\System\Contracts\UserBusinessContract;
use App\System\Contracts\UserRepositoryContract;
use App\System\Repositorys\UserRepository;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public $bindings = [
        UserBusinessContract::class => UserBusiness::class,
        UserRepositoryContract::class => UserRepository::class
    ];
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
        MenuConfig::configureMenuModule();
        $this->addDirectoryMigration();

    }

    private function addDirectoryMigration(){
        $mainPath = database_path('migrations');
        $directories = glob(app_path('Modules') . '/*/Migrations' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        $this->loadMigrationsFrom($paths);
    }
}
