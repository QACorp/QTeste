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



        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());

        $roleAuditor = Role::findByName('AUDITOR');
        $roleAuditor->givePermissionTo([

            ]);
        $roleGestor = Role::findByName('GESTOR');
        $roleGestor->givePermissionTo([

            ]);
        $roleDesenvolvedor = Role::findByName('DESENVOLVEDOR');
        $roleDesenvolvedor->givePermissionTo([

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
