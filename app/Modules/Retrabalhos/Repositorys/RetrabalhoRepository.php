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
        $retrabalho->load(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario', 'tarefa']);
        return RetrabalhoCasoTesteDTO::from($retrabalho);
    }

    public function buscarPorId(int $idRetrabalho): ?RetrabalhoCasoTesteDTO
    {
        $retrabalho = Retrabalho::select('retrabalhos.*')
        ->with([
            'caso_teste',
            'aplicacao',
            'tipo_retrabalho',
            'projeto',
            'usuario',
            'usuario_criador',
            'tarefa'
        ])->find($idRetrabalho);
        return $retrabalho ? RetrabalhoCasoTesteDTO::from($retrabalho) : null;
    }

    public function buscarTodosPorEquipe(int $idEquipe): DataCollection
    {
        $retrabalhos = Retrabalho::with(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario', 'usuario_criador', 'tarefa'])
            ->addSelect('retrabalhos.*')
            ->where('aplicacoes_equipes.equipe_id',$idEquipe)
            ->get();
        return RetrabalhoCasoTesteDTO::collection($retrabalhos);
    }

    public function remover(int $idRetrabalho): bool
    {
        return Retrabalho::select('retrabalhos.*')->where('retrabalhos.id',$idRetrabalho)->first()->delete();
    }

    public function editar(RetrabalhoCasoTesteDTO $retrabalhoCasoTesteDTO): RetrabalhoCasoTesteDTO
    {
        $retrabalho = Retrabalho::select('retrabalhos.*')->where('retrabalhos.id',$retrabalhoCasoTesteDTO->id)->first();
        $retrabalho->fill($retrabalhoCasoTesteDTO->toArray());
        $retrabalho->save();
        $retrabalho->load(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario', 'usuario_criador', 'tarefa']);

        return RetrabalhoCasoTesteDTO::from($retrabalho);
    }

    public function buscarTodosPorUsuario(int $idUsuario): DataCollection
    {
        $retrabalhos = Retrabalho::with(['caso_teste', 'aplicacao', 'tipo_retrabalho', 'projeto', 'usuario', 'usuario_criador', 'tarefa'])
            ->addSelect('retrabalhos.*')
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
