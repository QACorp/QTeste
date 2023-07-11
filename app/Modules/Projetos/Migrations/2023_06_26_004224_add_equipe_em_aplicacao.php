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
        Schema::create('projetos.aplicacoes_equipes', function (Blueprint $table) {
            $table->bigInteger('equipe_id');
            $table->bigInteger('aplicacao_id');
            $table->foreign('equipe_id')->on('equipes')->references('id');
            $table->foreign('aplicacao_id')->on('projetos.aplicacoes')->references('id');

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
