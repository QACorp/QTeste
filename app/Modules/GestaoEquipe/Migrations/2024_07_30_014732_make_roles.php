<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Role::create(['name' => 'GESTOR_API', 'guard_name' => 'api']);
        Role::create(['name' => 'DESENVOLVEDOR_API', 'guard_name' => 'api']);
        Role::create(['name' => 'AUDITOR_API', 'guard_name' => 'api']);
        Role::create(['name' => 'ADMINISTRADOR_API', 'guard_name' => 'api']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
