<?php

namespace App\System\Http\Controllers;

use App\System\Contracts\Business\EmpresaBusinessContract;
use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Contracts\Business\UserBusinessContract;
use App\System\DTOs\EmpresaDTO;
use App\System\DTOs\EquipeDTO;
use App\System\DTOs\UserDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\DataCollection;

class EmpresaController extends Controller
{

    public function __construct(
        private readonly EmpresaBusinessContract $empresaBusiness
    )
    {
    }


    public function editar()
    {
        $empresa = $this->empresaBusiness->buscarEmpresaPorIdUsuario(Auth::user()->getAuthIdentifier());
        $administradores = $this->empresaBusiness->buscarAdministradorPorIdEmpresa($empresa->id);
        $heads = [
            ['label' => '#', 'width' => 10],
            'Nome',
            'E-mail'
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'ordering' => false,
            'paging' => false,
            'searching' => false,

        ];
        return view(
            'empresas.alterar', compact(
                'empresa',
                'administradores',
                'heads',
                'config')
        );
    }

    public function atualizar(EmpresaDTO $empresaDTO)
    {
        try {
            $empresaDTO->id = Auth::user()->empresa_id;
            $empresaDTO->usuarios = 9999;
            $this->empresaBusiness->alterar($empresaDTO);
            return redirect(route('users.alterar-empresa'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Dados da empresa alterados com sucesso']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('users.alterar-empresa'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }catch (NotFoundException $exception){
            return redirect(route('users.alterar-empresa'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Empresa não encontrada']]);
        }

    }

    public function convertUserToDTO(array $users):array
    {
        $arrUserDTO = [];
        foreach ($users['users'] as $user) {
            $arrUserDTO[] = UserDTO::from(['id' => $user[0]]);
        }
        return $arrUserDTO;
    }
    public function convertUserDTOToArray(DataCollection $users):array
    {
        $arrUser = [];
        foreach ($users as $user) {
            $arrUser[] = $user->id;
        }
        return $arrUser;
    }

}
