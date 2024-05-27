<?php

use App\Modules\Retrabalhos\Contracts\Business\TipoRetrabalhoBusinessContract;
use App\Modules\Retrabalhos\DTOs\TipoRetrabalhoDTO;
use App\Modules\Retrabalhos\Enums\TipoRetrabalhoEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tipoRetrabalhoBusiness = App::make(TipoRetrabalhoBusinessContract::class);
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'nome' => 'Erro Sonar ou análise de código manual',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'nome' => 'Informação na providência inexistente ou errada',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'nome' => 'Branch inexistente ou errada',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'nome' => 'Teste unitário quebrado',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'nome' => 'Teste unitário mal escrito',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'nome' => 'Erro de desenvolvimento',
            'tipo' => TipoRetrabalhoEnum::FUNCIONAL
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'nome' => 'Teste automatizado quebrado (E2E e API)',
            'tipo' => TipoRetrabalhoEnum::FUNCIONAL
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'nome' => 'Erro de análise de requisitos ou tarefa',
            'tipo' => TipoRetrabalhoEnum::FUNCIONAL
        ]));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
