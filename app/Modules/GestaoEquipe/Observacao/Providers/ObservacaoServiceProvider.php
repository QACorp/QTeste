<?php

namespace App\Modules\GestaoEquipe\Observacao\Providers;


use App\Modules\GestaoEquipe\Checkpoint\Business\CheckpointBusiness;
use App\Modules\GestaoEquipe\Checkpoint\Business\UserBusiness;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\CheckpointBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Business\UserBusinessContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\CheckpointRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\ProjetoRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\Contracts\Respositories\UserRepositoryContract;
use App\Modules\GestaoEquipe\Checkpoint\Repositories\CheckpointRepository;
use App\Modules\GestaoEquipe\Checkpoint\Repositories\ProjetoRepository;
use App\Modules\GestaoEquipe\Checkpoint\Repositories\UserRepository;
use App\Modules\Projetos\Providers\ProjetosServiceProvider;

use App\System\Impl\ServiceProviderAbstract;


class ObservacaoServiceProvider extends ServiceProviderAbstract
{
    public static string $module_path = __DIR__ . '/GestaoEquipe\Observacao/';
    public static string $prefix = 'observacao';
    public static string $view_namespace = 'observacao';
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
        //DashboardConfig::addDashboardWidget(new Widget('x-retrabalho-total-equipe',12, ['ano' => date('Y')]));
        $this->moduleExists(ProjetosServiceProvider::class);
        parent::boot();
    }


}
