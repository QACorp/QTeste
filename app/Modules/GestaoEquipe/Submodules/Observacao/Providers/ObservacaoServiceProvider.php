<?php

namespace App\Modules\GestaoEquipe\Submodules\Observacao\Providers;


use App\Modules\GestaoEquipe\Submodules\Checkpoint\Business\UserBusiness;
use App\Modules\GestaoEquipe\Submodules\Checkpoint\Contracts\Business\UserBusinessContract;
use App\Modules\GestaoEquipe\Submodules\Checkpoint\Contracts\Respositories\ProjetoRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Checkpoint\Contracts\Respositories\UserRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Observacao\Business\ObservacaoBusiness;
use App\Modules\GestaoEquipe\Submodules\Observacao\Contracts\Business\ObservacaoBusinessContract;
use App\Modules\GestaoEquipe\Submodules\Observacao\Contracts\Respositories\ObservacaoRepositoryContract;
use App\Modules\GestaoEquipe\Submodules\Observacao\Repositories\ObservacaoRepository;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\System\Impl\ServiceProviderAbstract;


class ObservacaoServiceProvider extends ServiceProviderAbstract
{
    public static string $module_path = __DIR__ . '/GestaoEquipe\Submodule\Observacao/';
    public static string $prefix = 'observacao';
    public static string $view_namespace = 'observacao';
    public $bindings = [
        ObservacaoBusinessContract::class => ObservacaoBusiness::class,
        ObservacaoRepositoryContract::class => ObservacaoRepository::class
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
