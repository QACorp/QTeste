<?php

namespace App\Modules\Projetos\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'LISTAR_APLICACAO']);
        Permission::create(['name' => 'REMOVER_APLICACAO']);
        Permission::create(['name' => 'INSERIR_APLICACAO']);
        Permission::create(['name' => 'ALTERAR_APLICACAO']);

        Permission::create(['name' => 'LISTAR_PROJETO']);
        Permission::create(['name' => 'REMOVER_PROJETO']);
        Permission::create(['name' => 'INSERIR_PROJETO']);
        Permission::create(['name' => 'ALTERAR_PROJETO']);
        Permission::create(['name' => 'ADICIONAR_COMENTARIO_PROJETO']);
        Permission::create(['name' => 'ADICIONAR_DOCUMENTO_PROJETO']);

        Permission::create(['name' => 'LISTAR_PLANO_TESTE']);
        Permission::create(['name' => 'REMOVER_PLANO_TESTE']);
        Permission::create(['name' => 'INSERIR_PLANO_TESTE']);
        Permission::create(['name' => 'ALTERAR_PLANO_TESTE']);

        Permission::create(['name' => 'LISTAR_CASO_TESTE']);
        Permission::create(['name' => 'REMOVER_CASO_TESTE']);
        Permission::create(['name' => 'INSERIR_CASO_TESTE']);
        Permission::create(['name' => 'ALTERAR_CASO_TESTE']);

        Permission::create(['name' => 'LISTAR_EXECUCAO_PLANO_TESTE']);
        Permission::create(['name' => 'REMOVER_EXECUCAO_PLANO_TESTE']);
        Permission::create(['name' => 'INSERIR_EXECUCAO_PLANO_TESTE']);
        Permission::create(['name' => 'ALTERAR_EXECUCAO_PLANO_TESTE']);
        Permission::create(['name' => 'EXECUTAR_CASO_TESTE']);
        Permission::create(['name' => 'FINALIZAR_PLANO_TESTE']);

        $roleAdministrador = Role::create(['name' => 'ADMINISTRADOR']);
        $roleAdministrador->syncPermissions(Permission::all());

        $roleAuditor = Role::create(['name' => 'AUDITOR']);
        $roleAuditor->syncPermissions([
            'LISTAR_EXECUCAO_PLANO_TESTE',
            'REMOVER_EXECUCAO_PLANO_TESTE',
            'INSERIR_EXECUCAO_PLANO_TESTE',
            'ALTERAR_EXECUCAO_PLANO_TESTE',
            'LISTAR_CASO_TESTE',
            'REMOVER_CASO_TESTE',
            'INSERIR_CASO_TESTE',
            'ALTERAR_CASO_TESTE',
            'LISTAR_APLICACAO',
            'LISTAR_PROJETO',
            'LISTAR_PLANO_TESTE',
            'EXECUTAR_CASO_TESTE',
            'FINALIZAR_PLANO_TESTE',
            'ALTERAR_PROJETO'

        ]);

        $roleGestor= Role::create(['name' => 'GESTOR']);
        $roleGestor->syncPermissions([
            'LISTAR_EXECUCAO_PLANO_TESTE',
            'REMOVER_EXECUCAO_PLANO_TESTE',
            'INSERIR_EXECUCAO_PLANO_TESTE',
            'ALTERAR_EXECUCAO_PLANO_TESTE',
            'LISTAR_CASO_TESTE',
            'REMOVER_CASO_TESTE',
            'INSERIR_CASO_TESTE',
            'ALTERAR_CASO_TESTE',
            'LISTAR_APLICACAO',
            'LISTAR_PROJETO',
            'LISTAR_PLANO_TESTE',
            'ALTERAR_APLICACAO',
            'ADICIONAR_COMENTARIO_PROJETO',
            'ADICIONAR_DOCUMENTO_PROJETO'
        ]);

        $roleDesenvolvedor= Role::create(['name' => 'DESENVOLVEDOR']);
        $roleDesenvolvedor->syncPermissions([
            'LISTAR_EXECUCAO_PLANO_TESTE',
            'INSERIR_EXECUCAO_PLANO_TESTE',
            'LISTAR_CASO_TESTE',
            'LISTAR_APLICACAO',
            'LISTAR_PROJETO',
            'LISTAR_PLANO_TESTE',
            'EXECUTAR_CASO_TESTE',
            'FINALIZAR_PLANO_TESTE'
        ]);

    }
}
