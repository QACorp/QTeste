<?php

namespace App\System\Http\Controllers;

use App\System\Contracts\UserBusinessContract;
use App\System\DTOs\RoleDTO;
use App\System\DTOs\UserDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Spatie\LaravelData\DataCollection;

class UserController extends Controller
{
    public function __construct(
        private readonly UserBusinessContract $userBusiness
    )
    {
    }

    public function index()
    {
        $users = $this->userBusiness->buscarTodos();

        $heads = [
            ['label' => 'Id', 'width' => 10],
            ['label' => 'Nome', 'width' => 25],
            ['label' => 'E-mail', 'width' => 25],
            ['label' => 'Perfil', 'width' => 15],
            ['label' => 'Ações', 'width' => 20],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [null, null, null, null, ['orderable' => false]],
        ];
        return view('users.home', compact('users','heads', 'config'));
    }
    public function editar(Request $request, int $idUsuario)
    {
        $user = $this->userBusiness->buscarPorId($idUsuario);
        return view('users.alterar', [...compact('user'),'userController' => $this]);
    }
    public function atualizar(Request $request, int $idUsuario)
    {
        try {
            $userDTO = UserDTO::from([
                ...$request->only(['name', 'email']),
                'id' => $idUsuario,
                'roles' => $this->converterArrayEmRoleDTO($request->roles)
            ]);
            $this->userBusiness->alterar($userDTO);
            return redirect(route('users.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Usuário alterado com sucesso']]);
        }catch (NotFoundException $exception){
            return redirect(route('users.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Registro não encontrado']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('users.editar', $idUsuario))
                ->withErrors($exception->getValidator())
                ->withInput();
        }


    }
    private function converterArrayEmRoleDTO(array $roles): DataCollection
    {
        $collectionRoles = [];
        foreach ($roles as $role){
            $collectionRoles[] = ['name' => $role];
        }
        return RoleDTO::collection($collectionRoles);
    }

    public function convertArrayRoleDTO(array $lista):array
    {
        $roles = [];
        foreach ($lista as $item){
            if($item instanceof RoleDTO)
                $roles[] = $item;
            else
                $roles[] = RoleDTO::from(['name' => $item]);
        }
        return $roles;
    }
}
