<?php

namespace App\System\Http\Controllers;

use App\System\Contracts\Business\CoreConfiguracaoBusinessContract;
use App\System\DTOs\UserDTO;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Requests\ConfiguracaoRequest;
use App\System\Traits\Configuracao;
use Spatie\LaravelData\DataCollection;

class ConfiguracaoController extends Controller
{
    use Configuracao;
    public function __construct(
        private readonly CoreConfiguracaoBusinessContract $coreConfiguracaoBusiness
    )
    {
    }


    public function index()
    {
        $configuracoes = $this->buscarConfiguracoesPorPrefixo('core');
         return view(
            'configuracao.index', compact('configuracoes')
        );
    }

    public function salvar(ConfiguracaoRequest $configuracaoRequest)
    {
        try {
            $this->coreConfiguracaoBusiness->salvarConfiguracaoCore($configuracaoRequest);
            return redirect(route('configuracao.index'))
                ->with([Controller::MESSAGE_KEY_SUCCESS => ['Configurações da empresa alteradas com sucesso']]);
        }catch (UnprocessableEntityException $exception){
            return redirect(route('configuracao.index'))
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
    public function convertUserDTOToArray(DataCollection $users):array
    {
        $arrUser = [];
        foreach ($users as $user) {
            $arrUser[] = $user->id;
        }
        return $arrUser;
    }

}
