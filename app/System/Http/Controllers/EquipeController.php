<?php

namespace App\System\Http\Controllers;

use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Contracts\Business\UserBusinessContract;
use App\System\DTOs\EquipeDTO;
use App\System\DTOs\UserDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use Illuminate\Http\Request;
use Spatie\LaravelData\DataCollection;

class EquipeController extends Controller
{

    public function __construct(
        private readonly EquipeBusinessContract $equipeBusiness,
        private readonly UserBusinessContract $userBusiness
    )
    {
    }
    public function index()
    {
        $heads = [
            ['label' => 'Id', 'width' => 10],
            ['label' => 'Nome'],
            ['label' => 'Ações', 'width' => 20],
        ];

        $config = [
            ...config('adminlte.datatable_config'),
            'columns' => [null, null, ['orderable' => false]],
        ];
        $equipes = $this->equipeBusiness->buscarTodos();
        return view(
            'equipes.home',
            compact('equipes', 'heads', 'config'));
    }
    public function inserir(Request $request)
    {
        $users = $this->userBusiness->buscarTodos();
        return view('equipes.inserir', compact('users'));
    }

    public function salvar(Request $request)
    {
        try {
            $equipeDTO = EquipeDTO::from([
                ...$request->only(['nome']),
                'users' => UserDTO::collection($this->convertUserToDTO($request->only(['users'])))
            ]);
            $this->equipeBusiness->inserir($equipeDTO);
            return redirect(route('equipes.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Equipe inserida com sucesso']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('equipes.inserir'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }

    }

    public function editar(int $idEquipe)
    {
        $users = $this->userBusiness->buscarTodos();
        $equipe = $this->equipeBusiness->buscarEquipePorId($idEquipe);
        $idUsers = $this->convertUserDTOToArray($equipe->users);
        return view(
            'equipes.alterar',
            compact('users', 'equipe', 'idEquipe', 'idUsers')
        );
    }

    public function atualizar(Request $request, int $idEquipe)
    {
        try {
            $equipeDTO = EquipeDTO::from([
                'id' => $idEquipe,
                ...$request->only(['nome']),
                'users' => UserDTO::collection($this->convertUserToDTO($request->only(['users'])))
            ]);
            $this->equipeBusiness->alterar($equipeDTO);
            return redirect(route('equipes.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Equipe alterada com sucesso']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('equipes.editar'))
                ->withErrors($exception->getValidator())
                ->withInput();
        }catch (NotFoundException $exception){
            return redirect(route('equipes.index'))
                ->with([Controller::MESSAGE_KEY_ERROR => ['Equipe não encontrada']]);
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
