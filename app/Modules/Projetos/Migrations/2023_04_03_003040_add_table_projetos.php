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
        Schema::create('projetos.aplicacoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome',255);
            $table->longText('descricao')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('projetos.projetos', function (Blueprint $table) {
            $table->id();
            $table->string('nome',255);
            $table->longText('descricao')->nullable();
            $table->date('inicio');
            $table->date('termino');

            $table->bigInteger('aplicacao_id');
            $table->foreign('aplicacao_id')->on('projetos.aplicacoes')->references('id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('projetos.documentos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',255);
            $table->longText('descricao')->nullable();
            $table->longText('url');
            $table->bigInteger('projeto_id');
            $table->foreign('projeto_id')->on('projetos.projetos')->references('id');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('projetos.observacoes', function (Blueprint $table) {
            $table->id();
            $table->longText('observacao')->nullable();
            $table->bigInteger('projeto_id');
            $table->bigInteger('user_id');
            $table->foreign('projeto_id')->on('projetos.projetos')->references('id');
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
