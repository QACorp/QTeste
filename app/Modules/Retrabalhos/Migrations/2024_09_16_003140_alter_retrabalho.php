<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const SCHEMA = 'projetos.';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::SCHEMA . 'retrabalhos', function (Blueprint $table) {
            $table->foreignId('tarefa_id')->nullable()->constrained('projetos.tarefas');

        });
        $retrabalho = \App\Modules\Retrabalhos\Models\Retrabalho::all();
        foreach ($retrabalho as $item) {
            if(!$item->tarefa){
                continue;
            }
            $tarefa = \App\Modules\Projetos\Models\Tarefa::where('tarefa', $item->numero_tarefa)->first();
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
        Schema::table(self::SCHEMA . 'retrabalhos', function (Blueprint $table) {
            $table->dropColumn('numero_tarefa');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
