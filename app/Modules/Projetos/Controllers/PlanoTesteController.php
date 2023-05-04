<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\PlanoTesteBusinessContract;
use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Models\PlanoTeste;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanoTesteController extends Controller
{
    public function __construct(
        private readonly PlanoTesteBusinessContract $planoTesteBusiness,
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function index(int $idAplicacao, int $idProjeto){
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($idProjeto);
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
        $planos_teste = $this->planoTesteBusiness->buscarPlanosTestePorProjeto($idProjeto);
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
        return view('projetos::planos_teste.inserir',compact('idProjeto','idAplicacao'));
    }

    public function salvar(Request $request, int $idAplicacao, int $idProjeto)
    {
        try {
            $planoTesteDto = PlanoTesteDTO::from($request->all());
            $planoTesteDto->user_id = Auth::user()->id;
            $planoTesteDto->projeto_id = $idProjeto;
            $this->planoTesteBusiness->salvarPlanoTeste($planoTesteDto);

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
        try{
            $planoTeste = $this->planoTesteBusiness->buscarPlanoTestePorId($idPlanoTeste);
        }catch (NotFoundException $exception) {
            return redirect(route('aplicacoes.projetos.planos-teste.index', [$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }


        return view('projetos::planos_teste.alterar',compact(
            'idProjeto',
            'idAplicacao',
            'idPlanoTeste',
            'planoTeste'
        ));

    }
    public function alterar(Request $request, int $idAplicacao, int $idProjeto, int $idPlanoTeste)
    {
        try {
            $planoTesteDto = PlanoTesteDTO::from($request->all());
            $planoTesteDto->id = $idPlanoTeste;

            $this->planoTesteBusiness->alterarPlanoTeste($planoTesteDto);

            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Plano de teste alterado com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.planos-teste.index',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }catch (UnprocessableEntityException $exception) {
            dd($exception);
            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
}
