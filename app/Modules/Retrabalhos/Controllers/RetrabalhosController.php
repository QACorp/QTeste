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
            ['label' => 'Id', 'width' => 10],
            'Nome',
            'Descrição',
            ['label' => 'Ações', 'width' => 20],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [null, null, null, ['orderable' => false]],
        ];
        return view('retrabalhos::index', compact('heads', 'config', 'retrabalhos'));
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
        }catch (UnauthorizedException $e){
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }catch (NotFoundException $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }catch (UnprocessableEntityException $e){
            return redirect()->back()->withErrors($e->getValidator())->withInput();
        }
    }
    public function mostrarProvidencia(int $idRetrabalho){
        Auth::user()->can(PermissionEnum::LISTAR_RETRABALHO->value);
        $retrabalho = $this->retrabalhoBusiness->buscarPorId($idRetrabalho, Auth::id());

        return view('retrabalhos::show_providencia', compact('retrabalho'));
    }

}
