<?php

namespace App\Modules\GestaoEquipe\Providers;


use App\Modules\GestaoEquipe\Business\RelatoriosBusiness;
use App\Modules\GestaoEquipe\Contracts\Business\RelatoriosBusinessContract;
use App\Modules\GestaoEquipe\Contracts\Repository\RetrabalhoRepositoryContract;
use App\Modules\GestaoEquipe\Repositories\RetrabalhoRepository;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;

use App\System\Impl\ServiceProviderAbstract;


class GestaoEquipeServiceProvider extends ServiceProviderAbstract
{
    public static string $module_path = __DIR__ . '/GestaoEquipe';
    public static string $prefix = 'gestao-equipe';
    public static string $view_namespace = 'gestao-equipe';
    public $bindings = [
        RelatoriosBusinessContract::class => RelatoriosBusiness::class,
        RetrabalhoRepositoryContract::class => RetrabalhoRepository::class
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
