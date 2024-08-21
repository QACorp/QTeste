<?php

namespace App\Modules\GestaoEquipe\Checkpoint\Providers;


use App\Modules\Projetos\Providers\ProjetosServiceProvider;

use App\System\Impl\ServiceProviderAbstract;


class CheckpointServiceProvider extends ServiceProviderAbstract
{
    public static string $module_path = __DIR__ . '/GestaoEquipe\Checkpoint/';
    public static string $prefix = 'checkpoint';
    public static string $view_namespace = 'checkpoint';
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
