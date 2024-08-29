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
        Schema::create(self::SCHEMA . 'checkpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')->nullable()->constrained('projetos.projetos');
            $table->foreignId('criador_user_id')->constrained('users');
            $table->foreignId('user_id')->constrained('users');
            $table->text('descricao');
            $table->dateTime('data');
            $table->string('tarefa')->nullable();
            $table->boolean('compareceu');
            $table->timestamps();
            $table->softDeletes();
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
