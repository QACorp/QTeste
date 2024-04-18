<?php

namespace App\Modules\Retrabalhos\Providers;

use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\Retrabalhos\Config\MenuConfig;
use App\System\Contracts\Repository\UserRepositoryContract;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;

class RetrabalhosServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/Retrabalhos';
    protected string $prefix = 'retrabalhos';
    protected string $view_namespace = 'retrabalhos';
    public $bindings = [

    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        $this->moduleExists(ProjetosServiceProvider::class);
        MenuConfig::configureMenuModule();

        //DashboardConfig::addDashboardWidget(new Widget('x-totais-testes'));

        parent::boot();
    }


}
