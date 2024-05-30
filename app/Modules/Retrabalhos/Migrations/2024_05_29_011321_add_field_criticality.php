<?php

use App\Modules\Retrabalhos\Enums\CriticidadeEnum;
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
        Schema::table('projetos.retrabalhos', function (Blueprint $table) {
            $table->enum('criticidade',['Crítico', 'Baixa', 'Média', 'Alta'])->default(CriticidadeEnum::BAIXA->value);
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
