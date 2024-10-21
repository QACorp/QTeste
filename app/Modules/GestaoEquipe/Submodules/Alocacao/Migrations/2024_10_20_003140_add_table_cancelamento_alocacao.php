<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    const SCHEMA = 'gestao_equipes.';
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::SCHEMA.'alocacao_cancelamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alocacao_id')->constrained('gestao_equipes.alocacoes');
            $table->foreignId('user_id')->constrained('users');
            $table->text('motivo');
            $table->timestamps();
            $table->softDeletes();
        });
        Permission::create(['name' => 'CANCELAR_ALOCACAO', 'guard_name' => 'api']);
        $roleAdministrador = Role::findByName('ADMINISTRADOR_API', 'api');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'api')->get());

        $roleGestor = Role::findByName('GESTOR_API', 'api');
        $roleGestor->givePermissionTo([
            'CANCELAR_ALOCACAO'
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
