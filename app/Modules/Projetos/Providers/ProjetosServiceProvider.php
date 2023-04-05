<?php

namespace App\Modules\Projetos\Providers;

use App\Modules\Projetos\Business\AplicacaoBusiness;
use App\Modules\Projetos\Config\MenuConfig;
use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\AplicacaoRepositoryContract;
use App\Modules\Projetos\Repositorys\AplicacaoRepository;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class ProjetosServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/Projetos';
    protected string $prefix = 'projetos';
    protected string $view_namespace = 'projetos';
    public $bindings = [
        AplicacaoRepositoryContract::class => AplicacaoRepository::class,
        AplicacaoBusinessContract::class => AplicacaoBusiness::class
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
        MenuConfig::configureMenuModule();
        parent::boot();
    }


}
