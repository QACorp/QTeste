<?php

namespace App\Modules\Projetos\Controllers;


use App\Modules\Projetos\Contracts\CasoTesteBusinessContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CasoTesteController extends Controller
{
    public function __construct(
        private readonly CasoTesteBusinessContract $casoTesteBusiness
    )
    {
    }

    public function list(Request $request){
        return response($this->casoTesteBusiness->buscarCasoTestePorString($request->term)->toJson());
    }

    public function vincular(Request $request, $idAplicacao, $idProjeto, $idPlanoTeste)
    {
        $casoTesteDTO = CasoTesteDTO::from($request->all());
        $casoTesteDTO->id = $request->post('caso_teste_id');
        try{
            $this->casoTesteBusiness->vincular($idPlanoTeste, $casoTesteDTO);

            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Caso de teste vinculado com sucesso']]);

        }catch (UnprocessableEntityException $exception) {
            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Este caso de teste já está vinculado a este plano de teste! ']]);
        }catch (NotFoundException $exception) {
            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['O caso de teste informado não existe!']]);
        }
    }

    public function desvincular(Request $request, $idAplicacao, $idProjeto, $idPlanoTeste, $idCasoTeste)
    {

        try{
            $this->casoTesteBusiness->desvincular($idPlanoTeste, $idCasoTeste);

            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Caso de teste desvinculado com sucesso']]);

        }catch (UnprocessableEntityException $exception) {
            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Este caso de teste não está vinculado a este plano de teste! ']]);
        }catch (NotFoundException $exception) {
            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['O caso de teste informado não existe!']]);
        }
    }
    public function inserir(Request $request, int $idAplicacao, int $idProjeto, ?int $idPlanoTeste){
        $casoTesteDTO = CasoTesteDTO::from($request);
        try{
            $casoTeste = $this->casoTesteBusiness->inserirCasoTeste($casoTesteDTO);
            $this->casoTesteBusiness->vincular($idPlanoTeste, $casoTeste);
            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Caso de teste criado com sucesso', 'Caso de teste vinculado com sucesso']]);

        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.projetos.planos-teste.visualizar', [$idAplicacao, $idProjeto, $idPlanoTeste]))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Caso de teste não existe']]);
        }
    }
}
