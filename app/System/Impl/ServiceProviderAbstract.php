<?php

namespace App\System\Impl;

use App\System\Exceptions\InvalidServiceProviderClassException;
use App\System\Exceptions\ModuleNotFoundException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

abstract class ServiceProviderAbstract extends ServiceProvider
{
    public static string $prefix;
    public static string $view_namespace;
    public static string $module_path;

    protected MenuUtils $menuUtils;
    public function __construct($app)
    {
        parent::__construct($app);
    }

    public function boot(): void
    {
        $this->addConfigFiles();

        View::addNamespace(static::$view_namespace, base_path(static::$module_path. '/Views'));
        Route::prefix(static::$prefix)
            ->middleware(['web', 'auth'])
            ->group(base_path(static::$module_path. '/Routes/route.php'));

        $this->addDirectoryMigration();

    }

    public function moduleExists(string $providerModule):bool
    {

        if (!in_array(self::class,class_parents($providerModule))){
            throw new InvalidServiceProviderClassException();
        }

        if(!class_exists($providerModule)){
            throw new ModuleNotFoundException();
        }
        return true;
    }
    private function addDirectoryMigration():void
    {
        $mainPath = database_path('migrations');
        $directories = glob(base_path(static::$module_path. '/Migrations') , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);

        $this->loadMigrationsFrom($paths);
    }

    public function getPrefix(): string
    {
        return static::$prefix;
    }

    private function addConfigFiles():void{
        if(!app('config')->get(static::$prefix) &&
                file_exists(base_path(static::$module_path . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . static::$prefix . '.php'))) {
            app('config')->set(static::$prefix, require base_path(static::$module_path . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . static::$prefix . '.php'));
        }
    }
}
