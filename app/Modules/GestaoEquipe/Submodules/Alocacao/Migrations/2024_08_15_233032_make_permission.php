<?php

namespace App\Modules\GestaoEquipe\Submodules\Alocacao\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Permission::create(['name' => 'CONCLUIR_ALOCACAO', 'guard_name' => 'api']);
        Permission::create(['name' => 'CONCLUIR_ALOCACAO', 'guard_name' => 'web']);


        $roleAdministrador = Role::findByName('ADMINISTRADOR_API', 'api');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'api')->get());

        $roleAdministrador = Role::findByName('ADMINISTRADOR', 'web');
        $roleAdministrador->syncPermissions(Permission::where('guard_name', 'web')->get());

        $roleGestor = Role::findByName('GESTOR', 'web');
        $roleGestor->givePermissionTo([
            'CONCLUIR_ALOCACAO',
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
