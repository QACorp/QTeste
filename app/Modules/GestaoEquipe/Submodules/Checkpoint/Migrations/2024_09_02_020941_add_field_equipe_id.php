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
            $table->foreignId('equipe_id')->constrained('equipes');
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
