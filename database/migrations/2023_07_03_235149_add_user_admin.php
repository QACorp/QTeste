<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $userAdministrativo = new \App\System\Models\User([
            'name' => 'Administrador',
            'email' => 'administrador@administrador.com',
            'password' => \Illuminate\Support\Facades\Hash::make('admin')
        ]);
        $userAdministrativo->save();
        //$roleAdministrador = Role::findByName('ADMINISTRADOR');
        $userAdministrativo->syncRoles(['ADMINISTRADOR']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
