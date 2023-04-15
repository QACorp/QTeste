<?php

namespace App\Modules\Projetos\Repositorys;

use App\Modules\Projetos\Contracts\AplicacaoRepositoryContract;
use App\Modules\Projetos\DTOs\AplicacaoDTO;
use App\Modules\Projetos\Models\Aplicacao;
use Spatie\LaravelData\DataCollection;

class AplicacaoRepository implements AplicacaoRepositoryContract
{

    public function buscarTodos(): DataCollection
    {
        return AplicacaoDTO::collection(Aplicacao::all());
    }

    public function salvar(AplicacaoDTO $aplicacaoDTO): AplicacaoDTO
    {
        $aplicacao = new Aplicacao($aplicacaoDTO->only('nome','descricao')->toArray());
        $aplicacao->save();
        return AplicacaoDTO::from($aplicacao);
    }

    public function buscarPorId(int $id): ?AplicacaoDTO
    {
        $aplicacao = Aplicacao::find($id);
        return ($aplicacao != null ?  AplicacaoDTO::from(Aplicacao::find($id)) : null);
    }

    public function alterar(AplicacaoDTO $aplicacaoDTO): AplicacaoDTO
    {
        $aplicacao = Aplicacao::find($aplicacaoDTO->id);
        $aplicacao->fill($aplicacaoDTO->toArray());
        $aplicacao->update();
        return AplicacaoDTO::from($aplicacao);
    }
}
