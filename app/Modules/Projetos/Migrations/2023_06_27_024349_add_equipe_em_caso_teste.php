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
        Schema::create('projetos.casos_teste_equipes', function (Blueprint $table) {
            $table->bigInteger('equipe_id');
            $table->bigInteger('caso_teste_id');
            $table->foreign('equipe_id')->on('equipes')->references('id');
            $table->foreign('caso_teste_id')->on('projetos.casos_teste')->references('id');

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
