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
        permission::create(['name' => 'ADICIONAR_COMENTARIO_PROJETO', 'guard_name' => 'api']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR_API', 'api');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'api')->get());

        $roleGestor = Role::findByName('GESTOR_API', 'api');
        $roleGestor->givePermissionTo([
            'ADICIONAR_COMENTARIO_PROJETO'
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
