<?php

namespace App\Modules\GestaoEquipe\Controllers\Api;

use App\Modules\GestaoEquipe\Contracts\Business\AlocacaoBusinessContract;
use App\Modules\GestaoEquipe\DTOs\AlocacaoDTO;
use App\System\Http\Controllers\Controller;

class AlocacaoController extends Controller
{
    public function __construct(
        private readonly AlocacaoBusinessContract $alocacaoBusiness
    )
    {

    }
    public function criarAlocacao(AlocacaoDTO $alocacaoDTO){
        // TODO: Implement consultarAlocacao() method.
    }
    public function alterarAlocacao(AlocacaoDTO $alocacaoDTO, int $id){
        // TODO: Implement consultarAlocacao() method.
    }
    public function excluirAlocacao(int $id){
        // TODO: Implement consultarAlocacao() method.
    }
    public function listarAlocacoes(){
        return response()->json([]);
    }
    public function consultarAlocacao(int $id){
        // TODO: Implement consultarAlocacao() method.
    }





}
