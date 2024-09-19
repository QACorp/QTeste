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
        Permission::create(['name' => 'LISTAR_RETRABALHO', 'guard_name' => 'api']);
        Permission::create(['name' => 'REMOVER_RETRABALHO', 'guard_name' => 'api']);
        Permission::create(['name' => 'INSERIR_RETRABALHO', 'guard_name' => 'api' ]);
        Permission::create(['name' => 'ALTERAR_RETRABALHO', 'guard_name' => 'api']);
        Permission::create(['name' => 'VER_TODOS_RETRABALHOS', 'guard_name' => 'api']);

        Permission::create(['name' => 'ALTERAR_TODOS_RETRABALHOS', 'guard_name' => 'api']);
        Permission::create(['name' => 'REMOVER_TODOS_RETRABALHOS', 'guard_name' => 'api']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR_API', 'api');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'api')->get());

        $roleAuditor = Role::findByName('AUDITOR_API', 'api');
        $roleAuditor->givePermissionTo([
                'LISTAR_RETRABALHO',
                'REMOVER_RETRABALHO',
                'INSERIR_RETRABALHO',
                'ALTERAR_RETRABALHO',
                'VER_TODOS_RETRABALHOS'
            ]);
        $roleGestor = Role::findByName('GESTOR_API', 'api');
        $roleGestor->givePermissionTo([
                'VER_TODOS_RETRABALHOS'
            ]);
        $roleDesenvolvedor = Role::findByName('DESENVOLVEDOR_API', 'api');
        $roleDesenvolvedor->givePermissionTo([
            'LISTAR_RETRABALHO',
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
