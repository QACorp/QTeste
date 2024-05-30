<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projetos.tipos_retrabalhos', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->enum('tipo', ['Funcional', 'Análise de código']);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('projetos.retrabalhos', function (Blueprint $table) {
            $table->id();
            $table->text('descricao');
            $table->date('data');
            $table->text('motivo_exclusao')->nullable();
            $table->string('numero_tarefa')->nullable();
            $table->foreignId('tipo_retrabalho_id')->constrained('projetos.tipos_retrabalhos');
            $table->foreignId('usuario_criador_id')->constrained('users');
            $table->foreignId('usuario_id')->constrained('users');
            $table->foreignId('projeto_id')->nullable()->constrained('projetos.projetos');
            $table->foreignId('aplicacao_id')->constrained('projetos.aplicacoes');
            $table->foreignId('caso_teste_id')->nullable()->constrained('projetos.casos_teste');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_rework');
    }
};
