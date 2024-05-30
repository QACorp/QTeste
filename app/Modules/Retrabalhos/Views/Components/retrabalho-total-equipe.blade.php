
<div class="row">
    <div class="col-md-12">
        <h3>Retrabalhos</h3>
    </div>
    <div class="col-md-4">
        <x-adminlte-small-box title="{{ $totalRetrabalho }}"
                              text="Retrabalhos da equipe"
                              icon="fas fa-bug text-dark"
                              theme="teal" />
    </div>
    <div class="col-md-4">
        <x-adminlte-small-box title="{{ number_format($totalRetrabalhoPorEquipeTarefa,2,',') }}"
                              text="Retrabalhos por tarefa"
                              icon="fas fa-heartbeat text-dark"
                              theme="warning" />
    </div>
    <div class="col-md-4">
        <x-adminlte-small-box title="{{ number_format($totalRetrabalhoPorEquipeDesenvolvedor,2,',') }}"
                              text="Retrabalhos por usuário"
                              icon="fas fa-user-times text-dark"
                              theme="danger" />
    </div>
</div>

