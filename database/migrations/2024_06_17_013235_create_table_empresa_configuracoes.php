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
        Schema::create('empresa_configuracoes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('valor');
            $table->boolean('valor_criptografado')->default(false);
            $table->string('descricao', 300)->nullable();
            $table->string('prefixo_modulo');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_empresa_configuracoes');
    }
};
