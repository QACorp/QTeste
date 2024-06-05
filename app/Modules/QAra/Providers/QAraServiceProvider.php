<?php

namespace App\Modules\QAra\Providers;

use App\Modules\Projetos\Providers\ProjetosServiceProvider;
use App\Modules\QAra\Config\MenuConfig;
use App\System\Impl\ServiceProviderAbstract;

class QAraServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/QAra';
    protected string $prefix = 'qara';
    protected string $view_namespace = 'qara';

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

        parent::boot();
    }


}
