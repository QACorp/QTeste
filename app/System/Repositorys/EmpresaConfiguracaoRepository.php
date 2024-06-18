<?php

namespace App\System\Repositorys;

use App\System\Contracts\Business\UserBusinessContract;
use App\System\Contracts\Repository\EmpresaConfiguracaoRepositoryContract;
use App\System\Contracts\Repository\EmpresaRepositoryContract;
use App\System\DTOs\EmpresaConfiguracaoDTO;
use App\System\DTOs\EmpresaDTO;
use App\System\DTOs\UserDTO;
use App\System\Enums\PermissionEnum;
use App\System\Enums\RoleEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Impl\BaseRepository;
use App\System\Models\Empresa;
use App\System\Models\EmpresaConfiguracao;
use App\System\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\DataCollection;

class EmpresaConfiguracaoRepository extends BaseRepository  implements EmpresaConfiguracaoRepositoryContract
{
    public function __construct(
    )
    {
    }

    public function salvar(EmpresaConfiguracaoDTO $data): EmpresaConfiguracaoDTO
    {
        $configuracao = new EmpresaConfiguracao($data->toArray());
        $configuracao->save();
        return EmpresaConfiguracaoDTO::from($configuracao);
    }

    public function alterar(EmpresaConfiguracaoDTO $data): EmpresaConfiguracaoDTO
    {
        $configuracao = EmpresaConfiguracao::find($data->id);
        if (!$configuracao) {
            throw new NotFoundException('Configuração não encontrada');
        }
        $configuracao->fill($data->toArray());
        $configuracao->save();
        return EmpresaConfiguracaoDTO::from($configuracao);
    }

    public function excluir(string $prefixo, string $nome): bool
    {
        $configuracao = EmpresaConfiguracao::where('prefixo_modulo', $prefixo)->where('nome', $nome)->first();
        if (!$configuracao) {
            throw new NotFoundException('Configuração não encontrada');
        }
        $configuracao->delete();
        return true;
    }

    public function buscarPorConfiguracao(string $prefixo, string $nome): EmpresaConfiguracaoDTO
    {
        $configuracao = EmpresaConfiguracao::where('prefixo_modulo', $prefixo)
                            ->where('nome', $nome)
                            ->first();
        if (!$configuracao) {
            throw new NotFoundException('Configuração não encontrada');
        }
        return EmpresaConfiguracaoDTO::from($configuracao);
    }
}
