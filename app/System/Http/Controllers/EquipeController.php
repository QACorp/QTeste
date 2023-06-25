<?php

namespace App\System\Http\Controllers;

use App\System\Contracts\Business\EquipeBusinessContract;
use App\System\Contracts\Business\UserBusinessContract;
use App\System\DTOs\EquipeDTO;
use App\System\DTOs\UserDTO;
use App\System\Exceptions\UnprocessableEntityException;
use Illuminate\Http\Request;

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

    public function convertUserToDTO(array $users):array
    {
        $arrUserDTO = [];
        foreach ($users['users'] as $user) {
            $arrUserDTO[] = UserDTO::from(['id' => $user[0]]);
        }
        return $arrUserDTO;
    }

}
