<?php

namespace App\Modules\Projetos\Controllers;

use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\PlanoTesteExecucaoBusinessContract;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PlanoTesteExecucaoController extends Controller
{
    public function __construct(
        private readonly PlanoTesteExecucaoBusinessContract $planoTesteExecucaoBusiness,
        private readonly CasoTesteBusinessContract $casoTesteBusiness
    )
    {
    }

    public function executar(int $idAplicacao, int $idProjeto, int $idPlanoTeste)
    {
        //$this->planoTesteExecucaoBusiness->criarExecucaoTeste($idPlanoTeste);
        $planoTesteExecucao = $this->planoTesteExecucaoBusiness->buscarPlanoTesteExecucaoPorPlanoTeste($idPlanoTeste);
        $casosTeste = $this->casoTesteBusiness->buscarCasoTestePorPlanoTeste($idPlanoTeste);
        return view('projetos::plano_teste_execucao.home', compact('planoTesteExecucao', 'casosTeste'));
    }
}
