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
        Schema::table(self::SCHEMA . 'alocacoes', function (Blueprint $table) {
            $table->date('prorrogacao')->nullable();
            $table->text('motivo_prorrogacao')->nullable();
        });
        Permission::create(['name' => 'PRORROGAR_ALOCACAO', 'guard_name' => 'api']);
        $roleAdministrador = Role::findByName('ADMINISTRADOR_API', 'api');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'api')->get());

        $roleGestor = Role::findByName('GESTOR_API', 'api');
        $roleGestor->givePermissionTo([
            'PRORROGAR_ALOCACAO'
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
