@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuários que mais executaram testes</h3>
        </div>

        <div class="card-body">
            <x-adminlte-datatable
                id="users"
                :heads="$heads"
                :config="$config"
                compressed
                hoverable
                bordered
                striped>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->total_execucoes }}</td>
                    </tr>
                @endforeach
            </x-adminlte-datatable>
        </div>

        <div class="card-footer">
        </div>

    </div>
</div>
