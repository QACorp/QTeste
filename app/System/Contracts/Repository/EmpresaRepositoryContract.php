<?php

namespace App\System\Contracts\Repository;

use App\System\DTOs\EmpresaDTO;
use Spatie\LaravelData\DataCollection;

interface EmpresaRepositoryContract
{
    public function salvar(EmpresaDTO $data): EmpresaDTO;
    public function buscarEmpresaPorIdUsuario(int $idUsuario): EmpresaDTO;
    public function buscarAdministradorPorIdEmpresa(int $idEmpresa): DataCollection;
    //Criar método para alterar empresa
    public function alterar(EmpresaDTO $data): EmpresaDTO;

}
