<?php

namespace App\Modules\Retrabalhos\Controllers;


use App\Modules\Retrabalhos\Contracts\Business\RetrabalhoBusinessContract;
use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use App\Modules\Retrabalhos\Enums\PermissionEnum;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnauthorizedException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Http\Controllers\Controller;
use App\System\Traits\EquipeTools;
use App\System\Utils\EquipeUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class RetrabalhosController extends Controller
{
    use EquipeTools;
    public function __construct(
        private readonly RetrabalhoBusinessContract $retrabalhoBusiness
    )
    {

    }
    public function index()
    {

        $retrabalhos = $this->retrabalhoBusiness->buscarRetrabalho(EquipeUtils::equipeUsuarioLogado(), Auth::user()->getAuthIdentifier());

        $heads = [
            ['label' => '#', 'width' => 8],
            'Data',
            'Tarefa',
            'Usuário',
            'Criador',
            'Criticidade',
            ['label' => 'Ações', 'width' => 13],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => true],
                ['orderable' => false]
            ],
        ];
        return view('retrabalhos::index', compact('heads', 'config', 'retrabalhos'));
    }
    public function alterar(int $idRetrabalho)
    {

        $retrabalho = $this->retrabalhoBusiness->buscarPorId($idRetrabalho, Auth::user()->getAuthIdentifier());
        if($this->retrabalhoBusiness->canAlterarRetrabalho($retrabalho, Auth::user()->getAuthIdentifier())){
            return view('retrabalhos::alterar', compact('retrabalho'));
        }
        return redirect(route('retrabalhos.index'))
            ->with([Controller::MESSAGE_KEY_ERROR => ['Retrabalho não encontrado']]);


    }
    public function editar(int $idRetrabalho, RetrabalhoCasoTesteDTO $retrabalhoDTO)
    {
        $retrabalhoDTO->id = $idRetrabalho;


        try{

            $this->retrabalhoBusiness->editar(
                $retrabalhoDTO,
                Auth::user()->getAuthIdentifier(),
                EquipeUtils::equipeUsuarioLogado()
            );
            return redirect()->route('retrabalhos.index')
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Retrabalho alterado com sucesso']]);
        }catch (UnauthorizedException | NotFoundException $e){
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }catch (UnprocessableEntityException $e){
            return redirect()->back()->withErrors($e->getValidator())->withInput();
        }


    }
    public function inserir()
    {
        Auth::user()->can(PermissionEnum::INSERIR_RETRABALHO->value);
        return view('retrabalhos::inserir');
    }

    public function salvar(RetrabalhoCasoTesteDTO $retrabalhoDTO)
    {
        Auth::user()->can(PermissionEnum::INSERIR_RETRABALHO->value);
        try{
            $retrabalhoDTO->usuario_criador_id = Auth::id();
            $retrabalho = $this->retrabalhoBusiness->salvar($retrabalhoDTO, EquipeUtils::equipeUsuarioLogado());
            return redirect()->route('retrabalhos.providencia.index', $retrabalho->id)
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Retrabalho inserido com sucesso']]);
        }catch (UnauthorizedException | NotFoundException $e){
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }catch (UnprocessableEntityException $e){
            return redirect()->back()->withErrors($e->getValidator())->withInput();
        }
    }
    public function mostrarProvidencia(int $idRetrabalho){
        Auth::user()->can(PermissionEnum::LISTAR_RETRABALHO->value);
        $retrabalho = $this->retrabalhoBusiness->buscarPorId($idRetrabalho, Auth::user()->getAuthIdentifier());

        return view('retrabalhos::show_providencia', compact('retrabalho'));
    }

    public function excluir(int $idRetrabalho)
    {
        try{
            $this->retrabalhoBusiness->remover($idRetrabalho, Auth::user()->getAuthIdentifier());
            return redirect(route('retrabalhos.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Retrabalho removido com sucesso']]);
        }catch (UnauthorizedException $e) {
            return redirect(route('retrabalhos.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Permissão negada ao remover retrabalho']]);
        }catch (NotFoundException $exception){
            return redirect(route('retrabalhos.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }

    }

}
