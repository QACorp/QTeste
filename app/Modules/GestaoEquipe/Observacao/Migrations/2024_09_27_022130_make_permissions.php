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
        permission::create(['name' => 'LISTAR_OBSERVACAO', 'guard_name' => 'api']);
        permission::create(['name' => 'LISTAR_OBSERVACAO', 'guard_name' => 'web']);
        permission::create(['name' => 'INSERIR_OBSERVACAO', 'guard_name' => 'api']);
        permission::create(['name' => 'INSERIR_OBSERVACAO', 'guard_name' => 'web']);
        permission::create(['name' => 'ALTERAR_OBSERVACAO', 'guard_name' => 'api']);
        permission::create(['name' => 'ALTERAR_OBSERVACAO', 'guard_name' => 'web']);
        permission::create(['name' => 'REMOVER_OBSERVACAO', 'guard_name' => 'api']);
        permission::create(['name' => 'REMOVER_OBSERVACAO', 'guard_name' => 'web']);


        $roleAdministradorApi = Role::findByName('ADMINISTRADOR_API', 'api');
        $roleAdministradorApi->syncPermissions(Permission::where('guard_name', 'api')->get());

        $roleAdministradorApi = Role::findByName('ADMINISTRADOR', 'web');
        $roleAdministradorApi->syncPermissions(Permission::where('guard_name', 'web')->get());

        $roleGestorApi = Role::findByName('GESTOR_API', 'api');
        $roleGestorApi->givePermissionTo([
            'LISTAR_OBSERVACAO',
            'INSERIR_OBSERVACAO',
            'ALTERAR_OBSERVACAO',
            'ALTERAR_OBSERVACAO',
            'REMOVER_OBSERVACAO',

        ]);
        $roleGestorApi = Role::findByName('GESTOR', 'web');
        $roleGestorApi->givePermissionTo([
            'LISTAR_OBSERVACAO',
            'INSERIR_OBSERVACAO',
            'ALTERAR_OBSERVACAO',
            'ALTERAR_OBSERVACAO',
            'REMOVER_OBSERVACAO',

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
