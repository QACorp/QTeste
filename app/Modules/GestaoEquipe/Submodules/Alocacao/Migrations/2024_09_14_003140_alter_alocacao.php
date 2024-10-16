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
            $table->foreignId('tarefa_id')->nullable()->constrained('projetos.tarefas');

        });
        $alocacao = \App\Modules\GestaoEquipe\Submodules\Alocacao\Models\Alocacao::all();
        foreach ($alocacao as $item) {
            if(!$item->tarefa){
                continue;
            }
            $tarefa = \App\Modules\Projetos\Models\Tarefa::where('tarefa', $item->tarefa)->first();
            if($tarefa){
                $item->tarefa_id = $tarefa->id;
                $item->save();
                continue;
            }
            $tarefa = new \App\Modules\Projetos\Models\Tarefa();
            $tarefa->tarefa = $item->tarefa;
            $tarefa->titulo = 'Tarefa migrada';
            $tarefa->empresa_id = $item->empresa_id;
            $tarefa->save();
            $item->tarefa_id = $tarefa->id;
            $item->save();
        }
        Schema::table(self::SCHEMA . 'alocacoes', function (Blueprint $table) {
            $table->dropColumn('tarefa');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
