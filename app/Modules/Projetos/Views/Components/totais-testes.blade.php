<div class="card">
    <div class="card-header">
        <h3 class="card-title">Totais</h3>

    </div>

    <div class="card-body">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <span class="text-bold"><i class="fas fa-cogs"></i> Aplicações</span>
                <span class="float-right">{{ $totaisTeste->total_aplicacoes }}</span>
            </li>
            <li class="list-group-item"><span class="text-bold">
                    <i class="fas fa-project-diagram"></i> Projetos</span>
                <span class="float-right">{{ $totaisTeste->total_projetos }}</span>
            </li>
            <li class="list-group-item"><span class="text-bold">
                    <i class="fas fa-tasks"></i> Planos de teste</span>
                <span class="float-right">{{ $totaisTeste->total_planos_teste }}</span>
            </li>
            <li class="list-group-item"><span class="text-bold">
                    <i class="fas fa-list"></i> Casos de teste</span>
                <span class="float-right">{{ $totaisTeste->total_casos_teste}}</span>
            </li>
        </ul>
    </div>
</div>
