<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\ObservacaoBusinessContract;
use App\Modules\Projetos\Contracts\ObservacaoRepositoryContract;
use App\Modules\Projetos\Contracts\ProjetoBusinessContract;
use App\Modules\Projetos\DTOs\ObservacaoDTO;
use App\Modules\Projetos\Requests\ObservacoesPostRequest;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\UserDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelData\DataCollection;

class ObservacaoBusiness implements ObservacaoBusinessContract
{
    public function __construct(
        private readonly ObservacaoRepositoryContract $observacaoRepository,
        private readonly ProjetoBusinessContract $projetoBusiness
    )
    {
    }

    public function buscarPorProjeto(int $projetoId): DataCollection
    {
        return $this->observacaoRepository->buscarPorProjeto($projetoId);
    }

    public function salvar(ObservacaoDTO $observacaoDTO): ObservacaoDTO
    {
        $projeto = $this->projetoBusiness->buscarPorIdProjeto($observacaoDTO->projeto_id);
        if(!$this->projetoBusiness->projetoExists($projeto->aplicacao_id, $projeto->id)){
            throw new NotFoundException();
        }

        $observacaoDTO->user = UserDTO::from(Auth::user());
        $observacaoDTO->user_id = Auth::user()->id;
        $validator = Validator::make($observacaoDTO->toArray(), (new ObservacoesPostRequest())->rules());

        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->observacaoRepository->salvar($observacaoDTO);
    }
}
