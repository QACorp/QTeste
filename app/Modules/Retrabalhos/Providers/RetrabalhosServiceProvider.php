<?php

namespace App\Modules\Retrabalhos\Providers;

use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\Retrabalhos\Business\RetrabalhoBusiness;
use App\Modules\Retrabalhos\Business\TipoRetrabalhoBusiness;
use App\Modules\Retrabalhos\Business\UserBusiness;
use App\Modules\Retrabalhos\Config\MenuConfig;
use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\UserBusinessContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\RetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\TipoRetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\UserRepositoryContract;
use App\Modules\Retrabalhos\Repositorys\RetrabalhoRepository;
use App\Modules\Retrabalhos\Repositorys\TipoRetrabalhoRepository;
use App\Modules\Retrabalhos\Repositorys\UserRepository;
use App\System\Impl\ServiceProviderAbstract;

class RetrabalhosServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/Retrabalhos';
    protected string $prefix = 'retrabalhos';
    protected string $view_namespace = 'retrabalhos';
    public $bindings = [
        RetrabalhoBusinessContract::class => RetrabalhoBusiness::class,
        RetrabalhoRepositoryContract::class => RetrabalhoRepository::class,
        TipoRetrabalhoBusinessContract::class => TipoRetrabalhoBusiness::class,
        TipoRetrabalhoRepositoryContract::class => TipoRetrabalhoRepository::class,
        UserBusinessContract::class => UserBusiness::class,
        UserRepositoryContract::class => UserRepository::class
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
