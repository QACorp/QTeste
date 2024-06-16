<?php

namespace App\System\Repositorys;

use App\System\Contracts\Repository\EmpresaRepositoryContract;
use App\System\DTOs\EmpresaDTO;
use App\System\Impl\BaseRepository;
use App\System\Models\Empresa;

class EmpresaRepository extends BaseRepository  implements EmpresaRepositoryContract
{


    public function salvar(EmpresaDTO $data): EmpresaDTO
    {
        $empresa = new Empresa($data->toArray());
        $empresa->save();
        return EmpresaDTO::from($empresa);
    }
}
