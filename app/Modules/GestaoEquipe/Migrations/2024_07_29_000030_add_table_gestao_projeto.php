<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const SCHEMA = 'gestao_equipes.';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::SCHEMA.'alocacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->nullable()->constrained('projetos.projetos');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('empresa_id')->constrained('empresas');
            $table->foreignId('equipe_id')->constrained('equipes');
            $table->date('inicio');
            $table->date('termino');
            $table->date('concluida')->nullable();
            $table->string('tarefa')->nullable();
            $table->enum('natureza',['Sustentação', 'Melhoria', 'Projeto'])->nullable();
            $table->text('observacao')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};