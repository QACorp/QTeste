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
        Schema::create('projetos.planos_teste', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',255);
            $table->longText('descricao')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('projeto_id');
            $table->foreign('projeto_id')->on('projetos.projetos')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('projetos.casos_teste', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',255);
            $table->string('requisito');
            $table->longText('cenario');
            $table->longText('teste');
            $table->longText('resultado_esperado');
            $table->enum('status', [
                'Em criação',
                'Em revisão',
                'Concluído',
            ]);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('projetos.caso_teste_plano_teste', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('caso_teste_id');
            $table->foreign('caso_teste_id')->on('projetos.casos_teste')->references('id');

            $table->bigInteger('plano_teste_id');
            $table->foreign('plano_teste_id')->on('projetos.planos_teste')->references('id');

        });

        Schema::create('projetos.plano_teste_execucoes', function (Blueprint $table) {
            $table->id();
            $table->enum('resultado', [
                'Passou',
                'Falhou',
                'Abandonado',
                'Em correção',
            ]);
            $table->dateTime('data_execucao')->nullable();
            $table->bigInteger('user_id');
            $table->bigInteger('caso_teste_plano_teste_id');
            $table->foreign('caso_teste_plano_teste_id')->on('projetos.casos_teste_planos_teste')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->softDeletes();
            $table->timestamps();
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
