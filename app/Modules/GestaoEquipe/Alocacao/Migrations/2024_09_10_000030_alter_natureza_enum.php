<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const SCHEMA = 'gestao_equipes.';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::SCHEMA . 'alocacoes', function (Blueprint $table) {
            $table->string('natureza', 255)->change();
        });

        DB::statement("ALTER TABLE " . self::SCHEMA . "alocacoes DROP CONSTRAINT alocacoes_natureza_check");
        DB::statement("ALTER TABLE " . self::SCHEMA . "alocacoes ADD CONSTRAINT check_natureza CHECK (natureza IN ('Sustentação', 'Melhoria', 'Projeto', 'Férias', 'Afastamento', 'Licença'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(self::SCHEMA . 'alocacoes', function (Blueprint $table) {
            $table->enum('natureza', ['Sustentação', 'Melhoria', 'Projeto', 'Férias', 'Afastamento', 'Licença'])->change();
        });

        DB::statement("ALTER TABLE " . self::SCHEMA . "alocacoes DROP CONSTRAINT check_natureza");
    }
};
