<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\Providers;

use App\Modules\GestaoEquipe\Submodules\Alocacao\Business\AlocacaoBusiness;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Contracts\Repositories\AlocacaoRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Contracts\Repositories\ProjetoRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Repositories\AlocacaoRepository;
use App\Modules\GestaoEquipe\Submodules\Alocacao\Repositories\ProjetoRepository;
use App\Modules\Projetos\Models\CasoTeste;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\Retrabalhos\Business\DashboardBusiness;
use App\Modules\Retrabalhos\Business\RelatorioBusiness;
use App\Modules\Retrabalhos\Business\RetrabalhoBusiness;
use App\Modules\Retrabalhos\Business\TipoRetrabalhoBusiness;
use App\Modules\Retrabalhos\Business\UserBusiness;
use App\Modules\Retrabalhos\Components\GraficoEvolucaoRetrabalho;
use App\Modules\Retrabalhos\Components\GraficoEvolucaoRetrabalhoAplicacao;
use App\Modules\Retrabalhos\Components\GraficoEvolucaoRetrabalhoUsuario;
use App\Modules\Retrabalhos\Components\RetrabalhoTotalEquipe;
use App\Modules\Retrabalhos\Config\DashboardConfig;
use App\Modules\Retrabalhos\Contracts\Business\DashboardBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\RelatorioBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\Contracts\Business\UserBusinessContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\DashboardRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\RelatorioRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\RetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\TipoRetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\Contracts\Repositorys\UserRepositoryContract;
use App\Modules\Retrabalhos\Observers\CasoTesteObserver;
use App\Modules\Retrabalhos\Repositorys\DashoboardRepository;
use App\Modules\Retrabalhos\Repositorys\RelatorioRepository;
use App\Modules\Retrabalhos\Repositorys\RetrabalhoRepository;
use App\Modules\Retrabalhos\Repositorys\TipoRetrabalhoRepository;
use App\Modules\Retrabalhos\Repositorys\UserRepository;
use App\System\Component\Widget;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Support\Facades\Blade;

class AlocacaoServiceProvider extends ServiceProviderAbstract
{
    public static string $module_path = __DIR__ . '/GestaoEquipe\Submodules\Alocacao';
    public static string $prefix = 'alocacao';
    public static string $view_namespace = 'alocacao';
    public $bindings = [
        AlocacaoBusinessContract::class => AlocacaoBusiness::class,
        AlocacaoRepositoryContract::class => AlocacaoRepository::class,
        ProjetoRepositoryContract::class => ProjetoRepository::class
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
        //DashboardConfig::addDashboardWidget(new Widget('x-retrabalho-total-equipe',12, ['ano' => date('Y')]));
        $this->moduleExists(ProjetosServiceProvider::class);
        parent::boot();
    }


}
