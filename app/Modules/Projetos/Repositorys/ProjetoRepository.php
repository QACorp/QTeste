<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\ProjetoRepositoryContract;
use App\Modules\Projetos\DTOs\ProjetoDTO;
use App\Modules\Projetos\Models\Aplicacao;
use App\Modules\Projetos\Models\Projeto;
use Spatie\LaravelData\DataCollection;

class ProjetoRepository implements ProjetoRepositoryContract
{

    public function buscarTodosPorAplicacao(int $aplicacaoId): DataCollection
    {
        return ProjetoDTO::collection(
            Aplicacao::find($aplicacaoId)->projetos()->get()
        );
    }

    public function buscarPorId(int $idProjeto): ?ProjetoDTO
    {
        $projeto = Projeto::find($idProjeto);
        return $projeto != null ? ProjetoDTO::from($projeto) : null;
    }

    public function atualizar(ProjetoDTO $projetoDTO): ProjetoDTO
    {
        $projeto = Projeto::find($projetoDTO->id);
        $projeto->fill($projetoDTO->toArray());

        $projeto->update();
        return ProjetoDTO::from($projeto);

    }

    public function excluir(int $id): bool
    {
        $projeto = Projeto::find($id);
        return $projeto->delete();
    }
}
