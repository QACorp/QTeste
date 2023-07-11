<?php

namespace App\Modules\Projetos\Contracts\Business;

use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Requests\CasoTestePostRequest;
use App\Modules\Projetos\Requests\CasoTestePutRequest;
use App\Modules\Projetos\Requests\UploadPostRequest;
use Illuminate\Http\UploadedFile;
use Spatie\LaravelData\DataCollection;

interface CasoTesteBusinessContract
{
    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste, int $idEquipe): ?DataCollection;
    public function buscarCasoTestePorString(string $term, int $idEquipe): ?DataCollection;
    public function buscarCasoTestePorId(int $idCasoTeste, int $idEquipe): ?CasoTesteDTO;
    public function vincular(int $idPlanoTeste, int $idEquipe, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO;
    public function desvincular(int $idPlanoTeste, int $idEquipe, int $idCasoTeste): PlanoTesteDTO;
    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO, int $idEquipe, CasoTestePostRequest $casoTestePostRequest = new CasoTestePostRequest()):CasoTesteDTO;
    public function alterarCasoTeste(CasoTesteDTO $casoTesteDTO,int $idEquipe,  CasoTestePutRequest $casoTestePutRequest = new CasoTestePutRequest()):CasoTesteDTO;
    public function buscarTodos(int $idEquipe): DataCollection;
    public function excluir(int $idCasoTeste, int $idEquipe): bool;
    public function importarArquivoParaPlanoTeste(?UploadedFile $uploadedFile, ?int $planoTesteId, int $idEquipe, UploadPostRequest $uploadPostRequest = new UploadPostRequest()):void;
    public function importarArquivo(?UploadedFile $uploadedFile, int $idEquipe, UploadPostRequest $uploadPostRequest = new UploadPostRequest()): void;
}
