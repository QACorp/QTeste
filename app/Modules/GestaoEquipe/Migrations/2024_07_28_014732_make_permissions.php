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
        permission::create(['name' => 'VER_ALOCACAO']);
        Permission::create(['name' => 'CRIAR_ALOCACAO']);
        Permission::create(['name' => 'EDITAR_ALOCACAO']);
        Permission::create(['name' => 'EXCLUIR_ALOCACAO']);

        Permission::create(['name' => 'VER_MINHA_ALOCACAO']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());

        $roleAuditor = Role::findByName('AUDITOR');
        $roleAuditor->givePermissionTo([
            'VER_MINHA_ALOCACAO'
        ]);
        $roleGestor = Role::findByName('GESTOR');
        $roleGestor->givePermissionTo([
            'VER_ALOCACAO',
            'CRIAR_ALOCACAO',
            'EDITAR_ALOCACAO',
            'EXCLUIR_ALOCACAO',
            'VER_MINHA_ALOCACAO'
        ]);
        $roleDesenvolvedor = Role::findByName('DESENVOLVEDOR');
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
