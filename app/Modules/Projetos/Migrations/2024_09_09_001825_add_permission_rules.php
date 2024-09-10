<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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

        Permission::create(['name' => 'LISTAR_APLICACAO', 'guard_name' => 'api']);

        $roleAdministrador = Role::findByName('ADMINISTRADOR_API', 'api');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'api')->get());

        $roleAuditor = Role::findByName('AUDITOR_API', 'api');
        $roleAuditor->givePermissionTo([
            'LISTAR_APLICACAO',

        ]);

        $roleGestor = Role::findByName('GESTOR_API', 'api');
        $roleGestor->givePermissionTo([

            'LISTAR_APLICACAO'
        ]);

        $roleDesenvolvedor = Role::findByName('DESENVOLVEDOR_API', 'api');
        $roleDesenvolvedor->givePermissionTo([

            'LISTAR_APLICACAO'
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
