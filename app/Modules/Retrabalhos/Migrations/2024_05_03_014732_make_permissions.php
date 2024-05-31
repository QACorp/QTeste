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
        Permission::create(['name' => 'VER_RELATORIO_DESENVOLVEDOR']);
        Permission::create(['name' => 'VER_RELATORIO_GESTOR']);
        Permission::create(['name' => 'VER_RELATORIO_AUDITOR']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());

        $roleAuditor = Role::findByName('AUDITOR');
        $roleAuditor->givePermissionTo([
                'VER_RELATORIO_AUDITOR'
            ]);
        $roleGestor = Role::findByName('GESTOR');
        $roleGestor->givePermissionTo([
                'VER_RELATORIO_GESTOR'
            ]);
        $roleDesenvolvedor = Role::findByName('DESENVOLVEDOR');
        $roleDesenvolvedor->givePermissionTo([
            'VER_RELATORIO_DESENVOLVEDOR',
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
