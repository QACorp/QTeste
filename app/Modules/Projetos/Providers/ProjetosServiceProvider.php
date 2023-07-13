<?php

namespace App\Modules\Projetos\Providers;

use App\Modules\Projetos\Business\AplicacaoBusiness;
use App\Modules\Projetos\Business\CasosTesteMaisFalhasBusiness;
use App\Modules\Projetos\Business\CasoTesteBusiness;
use App\Modules\Projetos\Business\CasoTesteExecucaoBusiness;
use App\Modules\Projetos\Business\CoberturaTestesBusiness;
use App\Modules\Projetos\Business\DocumentoBusiness;
use App\Modules\Projetos\Business\GraficoExecucoesTestesMensaisBusiness;
use App\Modules\Projetos\Business\GraficoFalhasSucessoBusiness;
use App\Modules\Projetos\Business\ObservacaoBusiness;
use App\Modules\Projetos\Business\PlanoTesteBusiness;
use App\Modules\Projetos\Business\PlanoTesteExecucaoBusiness;
use App\Modules\Projetos\Business\PlanoTesteMaisExecutadoBusiness;
use App\Modules\Projetos\Business\ProjetoBusiness;
use App\Modules\Projetos\Business\TestesMaisExecutadosBusiness;
use App\Modules\Projetos\Business\TotaisTestesBusiness;
use App\Modules\Projetos\Business\UsuarioComMaisExecucoesBusiness;
use App\Modules\Projetos\Components\CasosTesteComMaisFalhas;
use App\Modules\Projetos\Components\CasoTesteDetalhes;
use App\Modules\Projetos\Components\GraficoAplicacoesComMaisTestes;
use App\Modules\Projetos\Components\GraficoExecucoesTestesMensais;
use App\Modules\Projetos\Components\GraficoFalhasSucesso;
use App\Modules\Projetos\Components\PlanoTesteMaisExecutados;
use App\Modules\Projetos\Components\TestesMaisExecutados;
use App\Modules\Projetos\Components\TotaisTestes;
use App\Modules\Projetos\Components\UsuarioComMaisExecucoes;
use App\Modules\Projetos\Config\DashboardConfig;
use App\Modules\Projetos\Config\MenuConfig;
use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\CasosTesteMaisFalhasBusinessContract;
use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\CasoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\CoberturaTestesBusinessContract;
use App\Modules\Projetos\Contracts\Business\DocumentoBusinessContract;
use App\Modules\Projetos\Contracts\Business\GraficoExecucoesTestesMensaisBusinessContract;
use App\Modules\Projetos\Contracts\Business\GraficoFalhasSucessoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ObservacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\PlanoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\PlanoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\PlanoTesteMaisExecutadoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\Contracts\Business\TestesMaisExecutadosBusinessContract;
use App\Modules\Projetos\Contracts\Business\TotaisTestesBusinessContract;
use App\Modules\Projetos\Contracts\Business\UsuarioComMaisExecucoesBusinessContract;
use App\Modules\Projetos\Contracts\Repository\AplicacaoRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\CasosTesteMaisFalhasRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\CasoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\CasoTesteRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\CoberturaTestesRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\DocumentoRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\GraficoExecucoesTestesMensaisRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\GraficoFalhasSucessoRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\ObservacaoRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\PlanoTesteExecucaoRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\PlanoTesteMaisExecutadoRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\PlanoTesteRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\ProjetoRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\TestesMaisExecutadosRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\TotaisTestesRepositoryContract;
use App\Modules\Projetos\Contracts\Repository\UsuarioComMaisExecucoesRepositoryContract;
use App\Modules\Projetos\Repositorys\AplicacaoRepository;
use App\Modules\Projetos\Repositorys\CasosTesteMaisFalhasRepository;
use App\Modules\Projetos\Repositorys\CasoTesteExecucaoRepository;
use App\Modules\Projetos\Repositorys\CasoTesteRepository;
use App\Modules\Projetos\Repositorys\CoberturaTestesRepository;
use App\Modules\Projetos\Repositorys\DocumentoRepository;
use App\Modules\Projetos\Repositorys\GraficoExecucoesTestesMensaisRepository;
use App\Modules\Projetos\Repositorys\GraficoFalhasSucessoRepository;
use App\Modules\Projetos\Repositorys\ObservacaoRepository;
use App\Modules\Projetos\Repositorys\PlanoTesteExecucaoRepository;
use App\Modules\Projetos\Repositorys\PlanoTesteMaisExecutadoRepository;
use App\Modules\Projetos\Repositorys\PlanoTesteRepository;
use App\Modules\Projetos\Repositorys\ProjetoRepository;
use App\Modules\Projetos\Repositorys\TestesMaisExecutadosRepository;
use App\Modules\Projetos\Repositorys\TotaisTestesRepository;
use App\Modules\Projetos\Repositorys\UsuarioComMaisExecucoesRepository;
use App\System\Component\Widget;
use App\System\Impl\ServiceProviderAbstract;
use Illuminate\Support\Facades\Blade;

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
        ObservacaoRepositoryContract::class => ObservacaoRepository::class,
        DocumentoBusinessContract::class => DocumentoBusiness::class,
        DocumentoRepositoryContract::class => DocumentoRepository::class,
        PlanoTesteBusinessContract::class => PlanoTesteBusiness::class,
        PlanoTesteRepositoryContract::class => PlanoTesteRepository::class,
        CasoTesteBusinessContract::class => CasoTesteBusiness::class,
        CasoTesteRepositoryContract::class => CasoTesteRepository::class,
        PlanoTesteExecucaoBusinessContract::class => PlanoTesteExecucaoBusiness::class,
        PlanoTesteExecucaoRepositoryContract::class => PlanoTesteExecucaoRepository::class,
        CasoTesteExecucaoBusinessContract::class => CasoTesteExecucaoBusiness::class,
        CasoTesteExecucaoRepositoryContract::class => CasoTesteExecucaoRepository::class,
        TestesMaisExecutadosRepositoryContract::class => TestesMaisExecutadosRepository::class,
        TestesMaisExecutadosBusinessContract::class => TestesMaisExecutadosBusiness::class,
        PlanoTesteMaisExecutadoBusinessContract::class => PlanoTesteMaisExecutadoBusiness::class,
        PlanoTesteMaisExecutadoRepositoryContract::class => PlanoTesteMaisExecutadoRepository::class,
        UsuarioComMaisExecucoesBusinessContract::class => UsuarioComMaisExecucoesBusiness::class,
        UsuarioComMaisExecucoesRepositoryContract::class => UsuarioComMaisExecucoesRepository::class,
        TotaisTestesBusinessContract::class => TotaisTestesBusiness::class,
        TotaisTestesRepositoryContract::class => TotaisTestesRepository::class,
        CasosTesteMaisFalhasBusinessContract::class => CasosTesteMaisFalhasBusiness::class,
        CasosTesteMaisFalhasRepositoryContract::class => CasosTesteMaisFalhasRepository::class,
        GraficoFalhasSucessoBusinessContract::class => GraficoFalhasSucessoBusiness::class,
        GraficoFalhasSucessoRepositoryContract::class => GraficoFalhasSucessoRepository::class,
        CoberturaTestesBusinessContract::class => CoberturaTestesBusiness::class,
        CoberturaTestesRepositoryContract::class => CoberturaTestesRepository::class,
        GraficoExecucoesTestesMensaisRepositoryContract::class => GraficoExecucoesTestesMensaisRepository::class,
        GraficoExecucoesTestesMensaisBusinessContract::class => GraficoExecucoesTestesMensaisBusiness::class
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
        Blade::component('caso-teste-detalhes', CasoTesteDetalhes::class);
        Blade::component('totais-testes', TotaisTestes::class);
        Blade::component('grafico-execucoes-mensais', GraficoExecucoesTestesMensais::class);
        Blade::component('testes-mais-executados', TestesMaisExecutados::class);
        Blade::component('planos-testes-mais-executados', PlanoTesteMaisExecutados::class);
        Blade::component('usuario-com-mais-execucoes', UsuarioComMaisExecucoes::class);
        Blade::component('casos-teste-mais-falhas', CasosTesteComMaisFalhas::class);
        Blade::component('grafico-falha-sucesso', GraficoFalhasSucesso::class);
        Blade::component('grafico-aplicacoes-mais-testes', GraficoAplicacoesComMaisTestes::class);
        MenuConfig::configureMenuModule();
        DashboardConfig::addDashboardWidget(new Widget('x-totais-testes'));
        DashboardConfig::addDashboardWidget(new Widget('x-grafico-execucoes-mensais',8));

        DashboardConfig::addDashboardWidget(new Widget('x-grafico-falha-sucesso'));
        DashboardConfig::addDashboardWidget(new Widget('x-grafico-aplicacoes-mais-testes'));
        DashboardConfig::addDashboardWidget(new Widget('x-usuario-com-mais-execucoes'));

        DashboardConfig::addDashboardWidget(new Widget('x-casos-teste-mais-falhas',6));
        DashboardConfig::addDashboardWidget(new Widget('x-testes-mais-executados',6));
        DashboardConfig::addDashboardWidget(new Widget('x-planos-testes-mais-executados',6));

        parent::boot();
    }


}
