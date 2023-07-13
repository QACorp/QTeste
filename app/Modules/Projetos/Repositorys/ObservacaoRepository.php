<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\Repository\ObservacaoRepositoryContract;
use App\Modules\Projetos\DTOs\ObservacaoDTO;
use App\Modules\Projetos\Models\Observacao;
use App\Modules\Projetos\Models\Projeto;
use App\System\Impl\BaseRepository;
use Spatie\LaravelData\DataCollection;

class ObservacaoRepository extends BaseRepository implements ObservacaoRepositoryContract
{

    public function buscarPorProjeto(int $projetoId): DataCollection
    {
        return ObservacaoDTO::collection(
            Projeto::find($projetoId)
                ->observacoes()
                ->with('user')
                ->orderBy('created_at', 'DESC')
                ->get()
        );
    }

    public function salvar(ObservacaoDTO $observacaoDTO): ObservacaoDTO
    {
        $observacao = new Observacao($observacaoDTO->toArray());
        $observacao->user_id = $observacaoDTO->user->id;
        $observacao->save();
        return ObservacaoDTO::from($observacao);
    }
}
