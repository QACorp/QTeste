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
        Schema::create('equipes', function (Blueprint $table) {
            $table->id();
            $table->string('nome',255);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('users_equipes', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('equipe_id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('equipe_id')->on('equipes')->references('id');


        });
        //Permissoes
        Permission::create(['name' => 'LISTAR_EQUIPE']);
        Permission::create(['name' => 'INSERIR_EQUIPE']);
        Permission::create(['name' => 'ALTERAR_EQUIPE']);
        Permission::create(['name' => 'REMOVER_EQUIPE']);
        Permission::create(['name' => 'VINCULAR_EQUIPE']);

        $roleGestor = Role::findByName('GESTOR');
        $roleGestor->syncPermissions([
            'VINCULAR_EQUIPE'

        ]);
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
