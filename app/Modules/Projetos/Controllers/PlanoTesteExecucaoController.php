<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\CasoTesteExecucaoBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoBusinessContract;
use App\System\Exceptions\ConflictException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class PlanoTesteExecucaoController extends Controller
{
    public function __construct(
        private readonly PlanoTesteExecucaoBusinessContract $planoTesteExecucaoBusiness,
        private readonly CasoTesteBusinessContract $casoTesteBusiness,
        private readonly CasoTesteExecucaoBusinessContract $casoTesteExecucaoBusiness
    )
    {
    }

    public function executar(Request $request, int $idAplicacao, int $idProjeto, int $idPlanoTeste)
    {
        //$this->planoTesteExecucaoBusiness->criarExecucaoTeste($idPlanoTeste);
        $planoTesteExecucao = $this->planoTesteExecucaoBusiness->buscarPlanoTesteExecucaoPorPlanoTeste($idPlanoTeste);
        $casosTeste = $this->casoTesteBusiness->buscarCasoTestePorPlanoTeste($idPlanoTeste);
        if($casosTeste->count() == 0){
            $request->session()->flash(Controller::MESSAGE_KEY_WARNING, ['Este plano de teste não possui casos de teste a ser executado']);
        }
        return view('projetos::plano_teste_execucao.home', [...compact(
            'planoTesteExecucao',
            'casosTeste',
            'idAplicacao',
            'idProjeto'
            ),'casoTesteExecucaoBusiness' => $this->casoTesteExecucaoBusiness]
        );
    }

    public function criar(int $idAplicacao, int $idProjeto, int $idPlanoTeste)
    {

        //$this->planoTesteExecucaoBusiness->criarExecucaoTeste($idPlanoTeste);
        $planoTesteExecucao = $this->planoTesteExecucaoBusiness->criarExecucaoTeste($idPlanoTeste);
        return redirect(route('aplicacoes.projetos.planos-teste.executar',[$idAplicacao, $idProjeto, $idPlanoTeste]))
            ->with([Controller::MESSAGE_KEY_SUCCESS => ['Execução criada com sucesso'],]);

    }

    public function executarCasoTeste(Request $request,
                                      int $idAplicacao,
                                      int $idProjeto,
                                      int $idPlanoTeste,
                                      int $idPlanoTesteExecucao,
                                      int $idCasoTeste)
    {
        try{
            $this->casoTesteExecucaoBusiness->executarCasoTeste($idPlanoTesteExecucao, $idCasoTeste, $request->status);
            return redirect(route('aplicacoes.projetos.planos-teste.executar',[$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Caso de teste executado com sucesso']]);
        }catch (ConflictException $exception){
            return redirect(route('aplicacoes.projetos.planos-teste.executar',[$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Este caso de teste já foi executado']]);
        }

    }
    public function finalizar(Request $request,
                                      int $idAplicacao,
                                      int $idProjeto,
                                      int $idPlanoTeste,
                                      int $idPlanoTesteExecucao
    )
    {
        try {
            $this->planoTesteExecucaoBusiness->finalizarPlanoTesteExecucao($idPlanoTesteExecucao);
            return redirect(route('aplicacoes.projetos.planos-teste.executar',[$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Plano de teste finalizado com sucesso']]);
        }catch (ConflictException $exception){
            return redirect(route('aplicacoes.projetos.planos-teste.index',[$idAplicacao, $idProjeto]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Plano de teste não existe']]);
        }

    }

}
