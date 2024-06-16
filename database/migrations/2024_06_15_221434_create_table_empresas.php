<?php

use App\System\DTOs\EmpresaDTO;
use App\System\Models\Empresa;
use App\System\Repositorys\EmpresaRepository;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\App;
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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('usuarios')->default(99999);
            $table->timestamps();
            $table->softDeletes();
        });
        $empresa = EmpresaDTO::from([
            'nome' => 'Empresa Padrão',
            'usuarios' => 99999
        ]);
        $empresa = App::make(EmpresaRepository::class)->salvar($empresa);
        Schema::table('users', function (Blueprint $table) use($empresa) {
            $table->integer('empresa_id')->default($empresa->id)->after('name');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });

        Schema::table('equipes', function (Blueprint $table) use($empresa) {
            $table->integer('empresa_id')->default($empresa->id)->after('name');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
        Permission::create(['name' => 'ALTERAR_EMPRESA']);

        $roleAdministrador = Role::findByName('ADMINISTRADOR');
        $roleAdministrador->syncPermissions(Permission::all());
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_empresas');
    }
};
