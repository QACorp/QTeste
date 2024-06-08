<?php

namespace App\Modules\Retrabalhos\Repositorys;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Retrabalhos\Contracts\Repositorys\RetrabalhoRepositoryContract;
use App\Modules\Retrabalhos\DTOs\RetrabalhoCasoTesteDTO;
use App\Modules\Retrabalhos\DTOs\RetrabalhoDTO;
use App\Modules\Retrabalhos\Models\Retrabalho;
use Spatie\LaravelData\DataCollection;

class RetrabalhoRepository implements RetrabalhoRepositoryContract
{

    public function salvar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO): RetrabalhoCasoTesteDTO
    {
        $retrabalho = new Retrabalho($retrabalhoCasoTesteDTO->toArray());
        $retrabalho->save();
        $retrabalho->refresh();
        $retrabalho->load(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario']);
        return RetrabalhoCasoTesteDTO::from($retrabalho);
    }

    public function buscarPorId(int $idRetrabalho): ?RetrabalhoCasoTesteDTO
    {
        $retrabalho = Retrabalho::with(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario', 'usuario_criador'])->find($idRetrabalho);
        return $retrabalho ? RetrabalhoCasoTesteDTO::from($retrabalho) : null;
    }

    public function buscarTodosPorEquipe(int $idEquipe): DataCollection
    {
        $retrabalhos = Retrabalho::with(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario', 'usuario_criador'])
            ->addSelect('retrabalhos.*')
            ->join('projetos.aplicacoes', 'retrabalhos.aplicacao_id', '=', 'aplicacoes.id')
            ->join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
            ->where('aplicacoes_equipes.equipe_id',$idEquipe)
            ->get();
        return RetrabalhoCasoTesteDTO::collection($retrabalhos);
    }

    public function remover(int $idRetrabalho): bool
    {
        return Retrabalho::find($idRetrabalho)->delete();
    }

    public function editar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO): RetrabalhoCasoTesteDTO
    {
        $retrabalho = Retrabalho::find($retrabalhoCasoTesteDTO->id);
        $retrabalho->fill($retrabalhoCasoTesteDTO->toArray());
        $retrabalho->save();
        return RetrabalhoCasoTesteDTO::from($retrabalho);
    }

    public function buscarTodosPorUsuario(int $idUsuario): DataCollection
    {
        $retrabalhos = Retrabalho::with(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario', 'usuario_criador'])
            ->addSelect('retrabalhos.*')
            ->join('projetos.aplicacoes', 'retrabalhos.aplicacao_id', '=', 'aplicacoes.id')
            ->join('projetos.aplicacoes_equipes','aplicacoes_equipes.aplicacao_id','=','aplicacoes.id')
            ->where('retrabalhos.usuario_id',$idUsuario)
            ->orWhere('usuario_criador_id', $idUsuario)
            ->get();
        return RetrabalhoCasoTesteDTO::collection($retrabalhos);
    }

    public function buscarRetrabalhoPorCasoTeste(CasoTesteDTO $casoTesteDTO): DataCollection
    {
        return RetrabalhoDTO::collection(
            Retrabalho::where('caso_teste_id', $casoTesteDTO->id)->get()
        );
    }
}
