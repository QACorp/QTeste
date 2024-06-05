<?php

namespace App\Modules\QAraCasosTeste\Controllers;

use App\Modules\Projetos\Contracts\Business\AplicacaoBusinessContract;
use App\Modules\Projetos\Contracts\Business\ProjetoBusinessContract;
use App\Modules\QAraCasosTeste\Contracts\Business\QAraCasosTesteBusinessContract;
use App\Modules\QAraCasosTeste\DTOs\QAraCasosTesteDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Http\Controllers\Controller;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class QAraController
{
    public function __construct(
        private readonly QAraCasosTesteBusinessContract $qaraCasosTesteBusiness,
        private readonly ProjetoBusinessContract $projetoBusiness,
        private readonly AplicacaoBusinessContract $aplicacaoBusiness
    )
    {
    }

    public function gerarTexto(QAraCasosTesteDTO $qaraCasosTesteDTO){
        try{
            $casosTeste = $this->qaraCasosTesteBusiness->gerarTextoIA($qaraCasosTesteDTO, EquipeUtils::equipeUsuarioLogado());
            return view('qara::qara.casos-teste', compact(
                    'casosTeste'
                )
            );
        }catch (NotFoundException $e){
            return redirect(route('caso-teste.qara.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado.']]);
        }catch (UnauthorizedException $e){
            return redirect(route('caso-teste.qara.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Você não pode fazer isso.']]);
        }


    }
    public function index(Request $request)
    {
        $idAplicacao = $request->get('idAplicacao');
        $idProjeto = $request->get('idProjeto');
        $aplicacoes = $this->aplicacaoBusiness->buscarTodos(EquipeUtils::equipeUsuarioLogado());
        $projetos = Collection::empty();
        if($idAplicacao){
            $projetos = $this->projetoBusiness->buscarTodosPorAplicacao($idAplicacao, EquipeUtils::equipeUsuarioLogado());
        }
        return view('qara::qara.index', compact(
                    'aplicacoes', 'idAplicacao', 'idProjeto', 'projetos'
            )
        );
    }
}
