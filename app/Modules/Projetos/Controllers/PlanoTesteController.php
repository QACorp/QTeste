<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\PlanoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\PlanoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PlanoTesteController extends Controller
{
    public function __construct(
        private readonly PlanoTesteBusinessContract $planoTesteBusiness,
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly CasoTesteBusinessContract $casoTesteBusiness,
        private readonly PlanoTesteExecucaoBusinessContract $planoTesteExecucaoBusiness
    )
    {
    }

    public function index(){
        Auth::user()->can(PermissionEnum::LISTAR_PLANO_TESTE->value);
        $planos_teste = $this->planoTesteBusiness->buscarTodosPlanoTeste(EquipeUtils::equipeUsuarioLogado());

        $heads = [
            ['label' => 'Id', 'width' => 5],
            'Nome',
            ['label' => 'Aplicação', 'width' => 15],
            ['label' => 'Projeto', 'width' => 15],
            ['label' => 'Data de Criação', 'width' => 10],
            ['label' => 'Últ. Exec.', 'width' => 15],
            ['label' => 'Ações', 'width' => 10],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [null, null, null, null, null, null, ['orderable' => false]],
        ];
        return view('projetos::planos_teste.geral', compact(
            'heads',
            'config',
            'planos_teste'
        ));
    }
    public function indexPorProjeto(int $idAplicacao, int $idProjeto){
        Auth::user()->can(PermissionEnum::LISTAR_PLANO_TESTE->value);
        try {
            $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto, EquipeUtils::equipeUsuarioLogado());

        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.index', $idAplicacao))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }
        $heads = [
            ['label' => 'Id', 'width' => 10],
            'Nome',
            ['label' => 'Data de Criação', 'width' => 15],
            ['label' => 'Ações', 'width' => 20],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [null, null, null, ['orderable' => false]],
        ];
        $planos_teste = $this->planoTesteBusiness->buscarPlanosTestePorProjeto($idProjeto, EquipeUtils::equipeUsuarioLogado());
        return view('projetos::planos_teste.home', compact(
            'heads',
            'config',
            'planos_teste',
            'idProjeto',
            'idAplicacao',
            'projeto'
        ));
    }
    public function inserir(int $idAplicacao, int $idProjeto)
    {
        try {
            $this->projetoBusiness->buscarPorIdProjeto($idProjeto, EquipeUtils::equipeUsuarioLogado());
        }catch (NotFoundException $exception) {
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }
        Auth::user()->can(PermissionEnum::INSERIR_PLANO_TESTE->value);
        return view('projetos::planos_teste.inserir',compact('idProjeto','idAplicacao'));
    }

    public function salvar(Request $request, int $idAplicacao, int $idProjeto)
    {
        Auth::user()->can(PermissionEnum::INSERIR_PLANO_TESTE->value);
        try {
            $planoTesteDto = PlanoTesteDTO::from($request->all());
            $planoTesteDto->user_id = Auth::user()->id;
            $planoTesteDto->projeto_id = $idProjeto;
            $this->planoTesteBusiness->salvarPlanoTeste($planoTesteDto, EquipeUtils::equipeUsuarioLogado());

            return redirect(route('aplicacoes.projetos.planos-teste.index',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Plano de teste inserido com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }catch (UnprocessableEntityException $exception) {
            return redirect(route('aplicacoes.projetos.planos-teste.inserir', [$idAplicacao, $idProjeto]))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }

    public function excluir(int $idAplicacao, int $idProjeto, int $idPlanoTeste)
    {
        Auth::user()->can(PermissionEnum::REMOVER_PLANO_TESTE->value);
        try {
            $this->planoTesteBusiness->excluirPlanoTeste($idPlanoTeste);
            return redirect(route('aplicacoes.projetos.planos-teste.index',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Plano de teste excluído com sucesso']]);
        }catch (NotFoundException $exception) {
            return redirect(route('aplicacoes.projetos.planos-teste.index', [$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }
    }
    public function visualizar(int $idAplicacao, int $idProjeto, int $idPlanoTeste)
    {
        Auth::user()->can(PermissionEnum::LISTAR_PLANO_TESTE->value);

        try{
            $planoTeste = $this->planoTesteBusiness->buscarPlanoTestePorId($idPlanoTeste, EquipeUtils::equipeUsuarioLogado());
            $heads = [
                ['label' => 'Id', 'width' => 10],
                ['label' => 'Requisito', 'width' => 25],
                'Título',
                ['label' => 'Status', 'width' => 15],
                ['label' => 'Ações', 'width' => 20],
            ];

            $config = [
                ...config('adminlte.datatable_config'),
                'columns' => [null, null, null, null, ['orderable' => false]],
            ];
            $existePlanoTesteExecucao =
                $this->planoTesteExecucaoBusiness->buscarUltimoPlanoTesteExecucaoPorPlanoTeste($idPlanoTeste) != null;
            $casosTeste = $this->casoTesteBusiness->buscarCasoTestePorPlanoTeste($idPlanoTeste, EquipeUtils::equipeUsuarioLogado());

            $planoTesteExecucoes = $this->planoTesteExecucaoBusiness->buscarPlanosTesteExecucaoPorPlanoTeste($idPlanoTeste);
            $headsPlanoTesteExecucao = [
                ['label' => 'Id', 'width' => 10],
                ['label' => 'Data Criação', 'width' => 25],
                'Criador',
                ['label' => 'Status', 'width' => 15],
                ['label' => 'Ações', 'width' => 20],
            ];

            $configPlanoTesteExecucao = [
                ...config('adminlte.datatable_config'),
                'order' => [0,'ASC'],
                'columns' => [null, null,null, null, ['orderable' => false]],
            ];


            return view('projetos::planos_teste.alterar',compact(
                'idProjeto',
                'idAplicacao',
                'headsPlanoTesteExecucao',
                'configPlanoTesteExecucao',
                'planoTesteExecucoes',
                'idPlanoTeste',
                'planoTeste',
                'heads',
                'config',
                'casosTeste',
                'existePlanoTesteExecucao'
            ));

        }catch (NotFoundException $exception) {
            return redirect(route('aplicacoes.projetos.planos-teste.index', [$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }



    }
    public function alterar(Request $request, int $idAplicacao, int $idProjeto, int $idPlanoTeste)
    {
        Auth::user()->can(PermissionEnum::ALTERAR_PLANO_TESTE->value);
        try {

            $planoTesteDto = PlanoTesteDTO::from($request->all());
            $planoTesteDto->id = $idPlanoTeste;

            $this->planoTesteBusiness->alterarPlanoTeste($planoTesteDto, EquipeUtils::equipeUsuarioLogado());

            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Plano de teste alterado com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.planos-teste.index',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }catch (UnprocessableEntityException $exception) {
            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }

}
