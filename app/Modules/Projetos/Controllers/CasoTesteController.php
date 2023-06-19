<?php

namespace App\Modules\Projetos\Controllers;


use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CasoTesteController extends Controller
{
    public function __construct(
        private readonly CasoTesteBusinessContract $casoTesteBusiness
    )
    {
    }

    public function list(Request $request){
        Auth::user()->can(PermissionEnum::LISTAR_CASO_TESTE->value);
        return response($this->casoTesteBusiness->buscarCasoTestePorString($request->term)->toJson());
    }

    public function vincular(Request $request, $idAplicacao, $idProjeto, $idPlanoTeste)
    {
        Auth::user()->can(PermissionEnum::VINCULAR_CASO_TESTE->value);
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
            Auth::user()->can(PermissionEnum::DESVINCULAR_CASO_TESTE->value);
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
    public function inserirEVincular(Request $request, int $idAplicacao, int $idProjeto, ?int $idPlanoTeste){
        Auth::user()->can([PermissionEnum::INSERIR_CASO_TESTE->value,PermissionEnum::VINCULAR_CASO_TESTE->value]);

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

    public function index(){
        Auth::user()->can(PermissionEnum::LISTAR_CASO_TESTE->value);
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

        $casosTeste = $this->casoTesteBusiness->buscarTodos();
        return view('projetos::casos_teste.home',
            compact('heads', 'config', 'casosTeste'));
    }

    public function excluir(Request $request, int $idCasoTeste)
    {
        Auth::user()->can(PermissionEnum::REMOVER_CASO_TESTE->value);
        try{
            $this->casoTesteBusiness->excluir($idCasoTeste);
            return redirect(route('aplicacoes.casos-teste.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Caso de teste removido com sucesso']]);
        }catch (NotFoundException $e){
            return redirect(route('aplicacoes.casos-teste.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Caso de teste não existe']]);
        }
    }

    public function editar(Request $request, int $idCasoTeste)
    {
        Auth::user()->can(PermissionEnum::ALTERAR_CASO_TESTE->value);
        try{
            $casoTeste = $this->casoTesteBusiness->buscarCasoTestePorId($idCasoTeste);
            return view('projetos::casos_teste.alterar',compact('casoTeste'));
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.casos-teste.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }

    }
    public function atualizar(Request $request, int $idCasoTeste)
    {
        Auth::user()->can(PermissionEnum::ALTERAR_CASO_TESTE->value);
        try{
            $casoTesteDTO = CasoTesteDTO::from($request->all());
            $casoTesteDTO->id = $idCasoTeste;
            $this->casoTesteBusiness->alterarCasoTeste($casoTesteDTO);
            return redirect(route('aplicacoes.casos-teste.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Caso de Teste alterado com sucesso']]);
        }catch (UnprocessableEntityException $exception) {
            return redirect(route('aplicacoes.casos-teste.editar', $casoTesteDTO->id))
                ->withErrors($exception->getValidator())
                ->withInput();
        }catch (NotFoundException $exception){
            return redirect(route('aplicacoes.casos-teste.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }

    }

    public function inserir()
    {
        Auth::user()->can(PermissionEnum::INSERIR_CASO_TESTE->value);
        return view('projetos::casos_teste.inserir');
    }
    public function salvar(Request $request)
    {
        Auth::user()->can(PermissionEnum::INSERIR_CASO_TESTE->value);
        try{
            $casoTesteDTO = CasoTesteDTO::from($request->all());
            $this->casoTesteBusiness->inserirCasoTeste($casoTesteDTO);
            return redirect(route('aplicacoes.casos-teste.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Caso de Teste inserido com sucesso']]);
        }catch (UnprocessableEntityException $exception) {
            return redirect(route('aplicacoes.casos-teste.inserir'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }
    }
}
