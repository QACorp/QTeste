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
        Schema::table('projetos.plano_teste_execucoes', function (Blueprint $table) {
            $table->bigInteger('equipe_id');
            $table->foreign('equipe_id')->on('equipes')->references('id');
        });
        Schema::table('projetos.caso_teste_execucoes', function (Blueprint $table) {
            $table->bigInteger('equipe_id');
            $table->foreign('equipe_id')->on('equipes')->references('id');
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
