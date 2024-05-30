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
        Permission::create(['name' => 'LISTAR_RETRABALHO']);
        Permission::create(['name' => 'REMOVER_RETRABALHO']);
        Permission::create(['name' => 'INSERIR_RETRABALHO']);
        Permission::create(['name' => 'ALTERAR_RETRABALHO']);
        Permission::create(['name' => 'VER_TODOS_RETRABALHOS']);

        Permission::create(['name' => 'ALTERAR_TODOS_RETRABALHOS']);
        Permission::create(['name' => 'REMOVER_TODOS_RETRABALHOS']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());

        $roleAuditor = Role::findByName('AUDITOR');
        $roleAuditor->givePermissionTo([
                'LISTAR_RETRABALHO',
                'REMOVER_RETRABALHO',
                'INSERIR_RETRABALHO',
                'ALTERAR_RETRABALHO',
                'VER_TODOS_RETRABALHOS'
            ]);
        $roleGestor = Role::findByName('GESTOR');
        $roleGestor->givePermissionTo([
                'VER_TODOS_RETRABALHOS'
            ]);
        $roleDesenvolvedor = Role::findByName('DESENVOLVEDOR');
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
