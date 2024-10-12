<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    const SCHEMA = 'gestao_equipes.';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::SCHEMA . 'checkpoints', function (Blueprint $table) {
            $table->foreignId('alocacao_id')->nullable()->constrained(self::SCHEMA . 'alocacoes');
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
