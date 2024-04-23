<?php

namespace App\Modules\Retrabalhos\Providers;

use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\Retrabalhos\Business\RetrabalhoBusiness;
use App\Modules\Retrabalhos\Business\TipoRetrabalhoBusiness;
use App\Modules\Retrabalhos\Config\MenuConfig;
use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\RetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\TipoRetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\Repositorys\RetrabalhoRepository;
use App\Modules\Retrabalhos\Repositorys\TipoRetrabalhoRepository;
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
        RetrabalhoBusinessContract::class => RetrabalhoBusiness::class,
        RetrabalhoRepositoryContract::class => RetrabalhoRepository::class,
        TipoRetrabalhoBusinessContract::class => TipoRetrabalhoBusiness::class,
        TipoRetrabalhoRepositoryContract::class => TipoRetrabalhoRepository::class
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
