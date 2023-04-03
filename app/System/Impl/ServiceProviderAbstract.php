<?php

namespace App\System\Impl;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

abstract class ServiceProviderAbstract extends ServiceProvider
{
    protected string $prefix;
    protected string $view_namespace;
    protected string $module_path;
    public function boot(): void
    {
        View::addNamespace($this->view_namespace, app_path($this->module_path. '/Views'));
        Route::prefix($this->prefix)
            ->middleware(['web', 'auth'])
            ->group(app_path($this->module_path. '/Routes/route.php'));

    }

}
