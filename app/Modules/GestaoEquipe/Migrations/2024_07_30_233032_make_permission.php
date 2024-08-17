<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        permission::create(['name' => 'VER_ALOCACAO', 'guard_name' => 'api']);
        Permission::create(['name' => 'CRIAR_ALOCACAO', 'guard_name' => 'api']);
        Permission::create(['name' => 'EDITAR_ALOCACAO', 'guard_name' => 'api']);
        Permission::create(['name' => 'EXCLUIR_ALOCACAO', 'guard_name' => 'api']);

        Permission::create(['name' => 'VER_MINHA_ALOCACAO', 'guard_name' => 'api']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR_API', 'api');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'api')->get());

        $roleAuditor = Role::findByName('AUDITOR_API', 'api');
        $roleAuditor->givePermissionTo([
            'VER_MINHA_ALOCACAO'
        ]);
        $roleGestor = Role::findByName('GESTOR_API', 'api');
        $roleGestor->givePermissionTo([
            'VER_ALOCACAO',
            'CRIAR_ALOCACAO',
            'EDITAR_ALOCACAO',
            'EXCLUIR_ALOCACAO',
            'VER_MINHA_ALOCACAO'
        ]);
        $roleDesenvolvedor = Role::findByName('DESENVOLVEDOR_API', 'api');
        $roleDesenvolvedor->givePermissionTo([
            'VER_MINHA_ALOCACAO'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
