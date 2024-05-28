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
            'descricao' => 'Erro Sonar ou análise de código manual',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'descricao' => 'Informação na providência inexistente ou errada',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'descricao' => 'Branch inexistente ou errada',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'descricao' => 'Teste unitário quebrado',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'descricao' => 'Teste unitário mal escrito',
            'tipo' => TipoRetrabalhoEnum::ANALISE_CODIGO
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'descricao' => 'Erro de desenvolvimento',
            'tipo' => TipoRetrabalhoEnum::FUNCIONAL
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'descricao' => 'Teste automatizado quebrado (E2E e API)',
            'tipo' => TipoRetrabalhoEnum::FUNCIONAL
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'descricao' => 'Erro de análise de requisitos ou tarefa',
            'tipo' => TipoRetrabalhoEnum::FUNCIONAL
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'descricao' => 'Erro de performance',
            'tipo' => TipoRetrabalhoEnum::FUNCIONAL
        ]));
        $tipoRetrabalhoBusiness->createTipoRetrabalho(TipoRetrabalhoDTO::from([
            'descricao' => 'Erro de segurança',
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
