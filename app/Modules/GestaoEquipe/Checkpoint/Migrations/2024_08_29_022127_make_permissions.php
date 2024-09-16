<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        permission::create(['name' => 'VER_CHECKPOINT', 'guard_name' => 'api']);
        Permission::create(['name' => 'CRIAR_CHECKPOINT', 'guard_name' => 'api']);
        Permission::create(['name' => 'EDITAR_CHECKPOINT', 'guard_name' => 'api']);
        Permission::create(['name' => 'EXCLUIR_CHECKPOINT', 'guard_name' => 'api']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR_API', 'api');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'api')->get());

        $roleGestor = Role::findByName('GESTOR_API', 'api');
        $roleGestor->givePermissionTo([
            'VER_CHECKPOINT',
            'CRIAR_CHECKPOINT',
            'EDITAR_CHECKPOINT',
            'EXCLUIR_CHECKPOINT'
        ]);

        permission::create(['name' => 'VER_CHECKPOINT', 'guard_name' => 'web']);
        Permission::create(['name' => 'CRIAR_CHECKPOINT', 'guard_name' => 'web']);
        Permission::create(['name' => 'EDITAR_CHECKPOINT', 'guard_name' => 'web']);
        Permission::create(['name' => 'EXCLUIR_CHECKPOINT', 'guard_name' => 'web']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR', 'web');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'web')->get());

        $roleGestor = Role::findByName('GESTOR', 'web');
        $roleGestor->givePermissionTo([
            'VER_CHECKPOINT',
            'CRIAR_CHECKPOINT',
            'EDITAR_CHECKPOINT',
            'EXCLUIR_CHECKPOINT'
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
