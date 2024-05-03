<?php

namespace App\Modules\Retrabalhos\Providers;

use App\Modules\Projetos\Components\TotaisTestes;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\Retrabalhos\Business\DashboardBusiness;
use App\Modules\Retrabalhos\Business\RetrabalhoBusiness;
use App\Modules\Retrabalhos\Business\TipoRetrabalhoBusiness;
use App\Modules\Retrabalhos\Business\UserBusiness;
use App\Modules\Retrabalhos\Components\GraficoEvolucaoRetrabalho;
use App\Modules\Retrabalhos\Components\GraficoEvolucaoRetrabalhoAplicacao;
use App\Modules\Retrabalhos\Components\GraficoEvolucaoRetrabalhoUsuario;
use App\Modules\Retrabalhos\Components\RetrabalhoTotalEquipe;
use App\Modules\Retrabalhos\Config\DashboardConfig;
use App\Modules\Retrabalhos\Config\MenuConfig;
use App\Modules\Retrabalhos\Contracts\Business\DashboardBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\UserBusinessContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\DashboardRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\RetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\TipoRetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\UserRepositoryContract;
use App\Modules\Retrabalhos\Repositorys\DashoboardRepository;
use App\Modules\Retrabalhos\Repositorys\RetrabalhoRepository;
use App\Modules\Retrabalhos\Repositorys\TipoRetrabalhoRepository;
use App\Modules\Retrabalhos\Repositorys\UserRepository;
use App\System\Component\Widget;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Support\Facades\Blade;

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
        UserRepositoryContract::class => UserRepository::class,
        DashboardRepositoryContract::class => DashoboardRepository::class,
        DashboardBusinessContract::class => DashboardBusiness::class,
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
        Blade::component('grafico-evolucao-retrabalho-usuario', GraficoEvolucaoRetrabalhoUsuario::class);
        Blade::component('grafico-evolucao-retrabalho-aplicacao', GraficoEvolucaoRetrabalhoAplicacao::class);
        Blade::component('grafico-evolucao-retrabalho', GraficoEvolucaoRetrabalho::class);
        Blade::component('retrabalho-total-equipe', RetrabalhoTotalEquipe::class);
        DashboardConfig::addDashboardWidget(new Widget('x-retrabalho-total-equipe',12));
        $this->moduleExists(ProjetosServiceProvider::class);
        MenuConfig::configureMenuModule();

        //DashboardConfig::addDashboardWidget(new Widget('x-totais-testes'));

        parent::boot();
    }


}
