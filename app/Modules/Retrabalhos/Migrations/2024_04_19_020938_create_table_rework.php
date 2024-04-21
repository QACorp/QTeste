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
            $table->foreignId('id_tipo_retrabalho')->constrained('projetos.tipos_retrabalhos');
            $table->foreignId('id_usuario_criador')->constrained('users');
            $table->foreignId('id_usuario')->constrained('users');
            $table->foreignId('id_projeto')->nullable()->constrained('projetos.projetos');
            $table->foreignId('id_aplicacao')->constrained('projetos.aplicacoes');
            $table->foreignId('id_caso_teste')->nullable()->constrained('projetos.casos_teste');
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
