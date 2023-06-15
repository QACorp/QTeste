<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\UsuarioComMaisExecucoesBusinessContract;
use App\Modules\Projetos\Contracts\Repository\UsuarioComMaisExecucoesRepositoryContract;
use App\System\Impl\BusinessAbstract;
use Spatie\LaravelData\DataCollection;

class UsuarioComMaisExecucoesBusiness extends BusinessAbstract implements UsuarioComMaisExecucoesBusinessContract
{
    public function __construct(
        private readonly UsuarioComMaisExecucoesRepositoryContract $usuarioComMaisExecucoesRepository
    )
    {
    }

    public function buscarUsuarioPorOrdemExecucao(int $limit): DataCollection
    {
        return $this->usuarioComMaisExecucoesRepository->buscarUsuarioPorOrdemExecucao($limit);
    }
}
