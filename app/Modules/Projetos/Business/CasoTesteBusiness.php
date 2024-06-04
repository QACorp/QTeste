<?php

namespace App\Modules\Projetos\Business;

use App\Modules\Projetos\Contracts\Business\CasoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Business\PlanoTesteBusinessContract;
use App\Modules\Projetos\Contracts\Repository\CasoTesteRepositoryContract;
use App\Modules\Projetos\DTOs\CasoTesteDTO;
use App\Modules\Projetos\DTOs\PlanoTesteDTO;
use App\Modules\Projetos\Enums\CasoTesteEnum;
use App\Modules\Projetos\Enums\PermissionEnum;
use App\Modules\Projetos\Models\CasoTesteExcelModel;
use App\Modules\Projetos\Requests\CasoTestePostRequest;
use App\Modules\Projetos\Requests\CasoTestePutRequest;
use App\System\DTOs\EquipeDTO;
use App\System\Exceptions\NotFoundException;
use App\System\Exceptions\UnprocessableEntityException;
use App\System\Impl\BusinessAbstract;
use App\System\Requests\UploadPostRequest;
use App\System\Traits\Validation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\LaravelData\DataCollection;

class CasoTesteBusiness extends BusinessAbstract implements CasoTesteBusinessContract
{
    use Validation;
    public function __construct(
        private readonly CasoTesteRepositoryContract $casoTesteRespository,
        private readonly PlanoTesteBusinessContract  $planoTesteBusiness
    )
    {
    }

    public function buscarCasoTestePorPlanoTeste(int $idPlanoTeste, int $idEquipe): ?DataCollection
    {
        $this->can(PermissionEnum::LISTAR_CASO_TESTE->value);
        return $this->casoTesteRespository->buscarCasoTestePorPlanoTeste($idPlanoTeste, $idEquipe);
    }

    public function buscarCasoTestePorString(string $term, int $idEquipe): ?DataCollection
    {
        $this->can(PermissionEnum::LISTAR_CASO_TESTE->value);
        return $this->casoTesteRespository->buscarCasoTestePorString($term, $idEquipe);
    }

    public function vincular(int $idPlanoTeste, int $idEquipe, CasoTesteDTO $casoTesteDTO): PlanoTesteDTO
    {
        $this->can(PermissionEnum::VINCULAR_CASO_TESTE->value);
        if($this->casoTesteRespository->existeVinculo($idPlanoTeste, $casoTesteDTO->id, $idEquipe)){
            throw new UnprocessableEntityException();
        }

        if(!$this->casoTesteRespository->existeCasoTeste($casoTesteDTO->id, $idEquipe)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->vincular($idPlanoTeste, $idEquipe, $casoTesteDTO);
    }

    public function inserirCasoTeste(CasoTesteDTO $casoTesteDTO, int $idEquipe, CasoTestePostRequest $casoTestePostRequest = new CasoTestePostRequest()): CasoTesteDTO
    {
        $this->can(PermissionEnum::INSERIR_CASO_TESTE->value);
        $validator = Validator::make($casoTesteDTO->toArray(), $casoTestePostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }
        return $this->casoTesteRespository->inserirCasoTeste($casoTesteDTO);
    }

    public function desvincular(int $idPlanoTeste, int $idEquipe, int $idCasoTeste): PlanoTesteDTO
    {
        $this->can(PermissionEnum::DESVINCULAR_CASO_TESTE->value);
        if(!$this->casoTesteRespository->existeVinculo($idPlanoTeste, $idCasoTeste, $idEquipe)){
            throw new UnprocessableEntityException();
        }

        if(!$this->casoTesteRespository->existeCasoTeste($idCasoTeste, $idEquipe)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->desvincular($idPlanoTeste, $idEquipe, $idCasoTeste);
    }

    public function buscarTodos(int $idEquipe): DataCollection
    {
        $this->can(PermissionEnum::LISTAR_CASO_TESTE->value);
        return $this->casoTesteRespository->buscarTodos($idEquipe);
    }


    public function excluir(int $idCasoTeste, int $idEquipe): bool
    {
        $this->can(PermissionEnum::REMOVER_CASO_TESTE->value);
        if(!$this->casoTesteRespository->existeCasoTeste($idCasoTeste, $idEquipe)){
            throw new NotFoundException();
        }
        return $this->casoTesteRespository->excluir($idCasoTeste);
    }

    public function buscarCasoTestePorId(int $idCasoTeste, int $idEquipe): ?CasoTesteDTO
    {
        $this->can(PermissionEnum::LISTAR_CASO_TESTE->value);
        $casoTeste = $this->casoTesteRespository->buscarCasoTestePorId($idCasoTeste,  $idEquipe);
        if($casoTeste == null)
            throw new NotFoundException();

        return $casoTeste;
    }

    public function alterarCasoTeste(CasoTesteDTO $casoTesteDTO, int $idEquipe, CasoTestePutRequest $casoTestePutRequest = new CasoTestePutRequest()): CasoTesteDTO
    {
        $this->can(PermissionEnum::ALTERAR_CASO_TESTE->value);
        if(!$this->casoTesteRespository->existeCasoTeste($casoTesteDTO->id, $idEquipe))
            throw new NotFoundException();

        $this->validation($casoTesteDTO->toArray(), $casoTestePutRequest);

        return $this->casoTesteRespository->alterarCasoTeste($casoTesteDTO);
    }

    public function importarArquivoParaPlanoTeste(?UploadedFile $uploadedFile, ?int $planoTesteId, int $idEquipe ,UploadPostRequest $uploadPostRequest = new UploadPostRequest()): void
    {
        $this->can(PermissionEnum::IMPORTAR_PLANILHA_CASO_TESTE->value);

        $this->validation(['arquivo' => $uploadedFile], $uploadPostRequest);
        /** @throw NotFoundException::class */
        $this->planoTesteBusiness->buscarPlanoTestePorId($planoTesteId, $idEquipe);

        Storage::put('tmp/',$uploadedFile);
        $casoTeste = Excel::toCollection(new CasoTesteExcelModel(), Storage::path('tmp/'.$uploadedFile->hashName()));
        $casoTeste->each(function($item, $key) use($planoTesteId, $idEquipe){
            $item->each(function ($row, $key) use($planoTesteId, $idEquipe){
                if($row->get(1) != null && $row->get(0) != 'Tipo'){
                    $casoTesteDTO = $this->criarCasoTestePorLinhaXLSX($row, $idEquipe);
                    $this->casoTesteRespository->vincular($planoTesteId, $idEquipe, $casoTesteDTO);
                }
            });
        });

    }

    public function importarArquivo(?UploadedFile $uploadedFile, int $idEquipe, UploadPostRequest $uploadPostRequest = new UploadPostRequest()): void
    {
        $this->can(PermissionEnum::IMPORTAR_PLANILHA_CASO_TESTE->value);
        $validator = Validator::make(['arquivo' => $uploadedFile], $uploadPostRequest->rules());
        if ($validator->fails()) {
            throw new UnprocessableEntityException($validator);
        }

        Storage::put('tmp/',$uploadedFile);
        $casoTeste = Excel::toCollection(new CasoTesteExcelModel(), Storage::path('tmp/'.$uploadedFile->hashName()));
        $casoTeste->each(function($item, $key) use($idEquipe){
            $item->each(function ($row, $key) use($idEquipe){
                if($row->get(1) != null && $row->get(0) != 'Tipo'){
                    $casoTesteDTO = $this->criarCasoTestePorLinhaXLSX($row, $idEquipe);
                }
            });
        });

    }
    private function criarCasoTestePorLinhaXLSX(Collection $dados, int $idEquipe): CasoTesteDTO
    {
        $casoTesteDTO = CasoTesteDTO::from([
            'titulo' => substr($dados->get(2),0,254),
            'requisito' => $dados->get(1),
            'cenario' => $dados->get(2),
            'teste' => $dados->get(3),
            'resultado_esperado' => $dados->get(5),
            'status' => CasoTesteEnum::CONCLUIDO->value,
            'equipes' => EquipeDTO::collection([['id' => $idEquipe]])
        ]);
        $casoTesteDTO = $this->casoTesteRespository->inserirCasoTeste($casoTesteDTO, $idEquipe);
        return $casoTesteDTO;
    }

}
