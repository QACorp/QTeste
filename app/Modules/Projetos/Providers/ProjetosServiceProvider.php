<?php

namespace App\Modules\Projetos\Providers;

use App\Modules\Projetos\Business\AplicacaoBusiness;
use App\Modules\Projetos\Business\ObservacaoBusiness;
use App\Modules\Projetos\Business\ProjetoBusiness;
use App\Modules\Projetos\Config\MenuConfig;
use App\Modules\Projetos\Contracts\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\AplicacaoRepositoryContract;
use App\Modules\Projetos\Contracts\ObservacaoBusinessContract;
use App\Modules\Projetos\Contracts\ObservacaoRepositoryContract;
use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\ProjetoRepositoryContract;
use App\Modules\Projetos\Repositorys\AplicacaoRepository;
use App\Modules\Projetos\Repositorys\ObservacaoRespository;
use App\Modules\Projetos\Repositorys\ProjetoRepository;
use App\System\Impl\ServiceProviderAbstract;

class ProjetosServiceProvider extends ServiceProviderAbstract
{
    protected string $module_path = 'Modules/Projetos';
    protected string $prefix = 'projetos';
    protected string $view_namespace = 'projetos';
    public $bindings = [
        AplicacaoRepositoryContract::class => AplicacaoRepository::class,
        AplicacaoBusinessContract::class => AplicacaoBusiness::class,
        ProjetoRepositoryContract::class => ProjetoRepository::class,
        ProjetoBusinessContract::class => ProjetoBusiness::class,
        ObservacaoBusinessContract::class => ObservacaoBusiness::class,
        ObservacaoRepositoryContract::class => ObservacaoRespository::class
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
