<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\PlanoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Repository\CasoTesteRespositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Enums\CasoTesteEnum;
use App\Modules\Projetos\Models\CasoTesteExcelModel;
use App\Modules\Projetos\Requests\CasoTestePostRequest;
use App\Modules\Projetos\Requests\CasoTestePutRequest;
use App\Modules\Projetos\Requests\UploadPostRequest;
use App\System\Enuns\PermisissionEnum;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\LaravelData\DataCollection;

class CasoTesteBusiness extends BusinessAbstract implements CasoTesteBusinessContract
{
    public function __construct(
        private readonly CasoTesteRespositoryContract $casoTesteRespository,
        private readonly PlanoTesteBusinessContract $planoTesteBusiness
    )
    {
    }

    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste): ?DataCollection
    {
        $this->can(PermisissionEnum::LISTAR_CASO_TESTE->value);
        return $this->casoTesteRespository->buscarCasoTestePorPlanoTeste($idPlanoTeste);
    }

    public function buscarCasoTestePorString(string $term): ?DataCollection
    {
        $this->can(PermisissionEnum::LISTAR_CASO_TESTE->value);
        return $this->casoTesteRespository->buscarCasoTestePorString($term);
    }

    public function vincular(int $idPlanoTeste, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO
    {
        $this->can(PermisissionEnum::VINCULAR_CASO_TESTE->value);
        if($this->casoTesteRespository->existeVinculo($idPlanoTeste, $casoTesteDTO->id)){
            throw new UnprocessableEntityException();
        }

        if(!$this->casoTesteRespository->existeCasoTeste($casoTesteDTO->id)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->vincular($idPlanoTeste, $casoTesteDTO);
    }

    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO, CasoTestePostRequest $casoTestePostRequest = new CasoTestePostRequest()): CasoTesteDTO
    {
        $this->can(PermisissionEnum::INSERIR_CASO_TESTE->value);
        $validator = Validator::make($casoTesteDTO->toArray(), $casoTestePostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->casoTesteRespository->inserirCasoTeste($casoTesteDTO);
    }

    public function desvincular(int $idPlanoTeste, int $idCasoTeste): PlanoTesteDTO
    {
        $this->can(PermisissionEnum::DESVINCULAR_CASO_TESTE->value);
        if(!$this->casoTesteRespository->existeVinculo($idPlanoTeste, $idCasoTeste)){
            throw new UnprocessableEntityException();
        }

        if(!$this->casoTesteRespository->existeCasoTeste($idCasoTeste)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->desvincular($idPlanoTeste, $idCasoTeste);
    }

    public function buscarTodos(): DataCollection
    {
        $this->can(PermisissionEnum::LISTAR_CASO_TESTE->value);
        return $this->casoTesteRespository->buscarTodos();
    }

    public function excluir(int $idCasoTeste): bool
    {
        $this->can(PermisissionEnum::REMOVER_CASO_TESTE->value);
        if(!$this->casoTesteRespository->existeCasoTeste($idCasoTeste)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->excluir($idCasoTeste);
    }

    public function buscarCasoTestePorId(int $idCasoTeste): ?CasoTesteDTO
    {
        $this->can(PermisissionEnum::LISTAR_CASO_TESTE->value);
        $casoTeste = $this->casoTesteRespository->buscarCasoTestePorId($idCasoTeste);
        if($casoTeste == null)
            throw new NotFoundException();

        return $casoTeste;
    }

    public function alterarCasoTeste(CasoTesteDTO $casoTesteDTO, CasoTestePutRequest $casoTestePutRequest = new CasoTestePutRequest()): CasoTesteDTO
    {
        $this->can(PermisissionEnum::ALTERAR_CASO_TESTE->value);
        if(!$this->casoTesteRespository->existeCasoTeste($casoTesteDTO->id))
            throw new NotFoundException();

        $validator = Validator::make($casoTesteDTO->toArray(), $casoTestePutRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        return $this->casoTesteRespository->alterarCasoTeste($casoTesteDTO);
    }

    public function importarArquivoParaPlanoTeste(?UploadedFile $uploadedFile, ?int $planoTesteId, UploadPostRequest $uploadPostRequest = new UploadPostRequest()): void
    {
        $this->can(PermisissionEnum::IMPORTAR_PLANILHA_CASO_TESTE->value);
        $validator = Validator::make(['arquivo' => $uploadedFile], $uploadPostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        /** @throw NotFoundException::class */
        $this->planoTesteBusiness->buscarPlanoTestePorId($planoTesteId);

        Storage::put('tmp/',$uploadedFile);
        $casoTeste = Excel::toCollection(new CasoTesteExcelModel(), Storage::path('tmp/'.$uploadedFile->hashName()));
        $casoTeste->each(function($item, $key) use($planoTesteId){
            $item->each(function ($row, $key) use($planoTesteId){
                if($row->get(1) != null && $row->get(0) != 'Tipo'){
                    $casoTesteDTO = $this->criarCasoTestePorLinhaXLSX($row);
                    $this->casoTesteRespository->vincular($planoTesteId, $casoTesteDTO);
                }
            });
        });

    }

    public function importarArquivo(?UploadedFile $uploadedFile, UploadPostRequest $uploadPostRequest = new UploadPostRequest()): void
    {
        $this->can(PermisissionEnum::IMPORTAR_PLANILHA_CASO_TESTE->value);
        $validator = Validator::make(['arquivo' => $uploadedFile], $uploadPostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        Storage::put('tmp/',$uploadedFile);
        $casoTeste = Excel::toCollection(new CasoTesteExcelModel(), Storage::path('tmp/'.$uploadedFile->hashName()));
        $casoTeste->each(function($item, $key){
            $item->each(function ($row, $key){
                if($row->get(1) != null && $row->get(0) != 'Tipo'){
                    $casoTesteDTO = $this->criarCasoTestePorLinhaXLSX($row);
                }
            });
        });

    }
    private function criarCasoTestePorLinhaXLSX(Collection $dados): CasoTesteDTO
    {
        $casoTesteDTO = CasoTesteDTO::from([
            'titulo' => substr($dados->get(2),0,254),
            'requisito' => $dados->get(1),
            'cenario' => $dados->get(2),
            'teste' => $dados->get(3),
            'resultado_esperado' => $dados->get(5),
            'status' => CasoTesteEnum::CONCLUIDO->value
        ]);
        $casoTesteDTO = $this->casoTesteRespository->inserirCasoTeste($casoTesteDTO);
        return $casoTesteDTO;
    }
}
