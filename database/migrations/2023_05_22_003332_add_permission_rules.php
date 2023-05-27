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
        Role::create(['name' => 'GESTOR']);
        Role::create(['name' => 'DESENVOLVEDOR']);
        Role::create(['name' => 'AUDITOR']);
        Role::create(['name' => 'ADMINISTRADOR']);

        Permission::create(['name' => 'LISTAR_USUARIO']);
        Permission::create(['name' => 'INSERIR_USUARIO']);
        Permission::create(['name' => 'ALTERAR_USUARIO']);
        Permission::create(['name' => 'REMOVER_USUARIO']);
        Permission::create(['name' => 'ALTERAR_SENHA_USUARIO']);

        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
