@section('plugins.Select2', true)
<x-adminlte-select2
    id="equipes"
    name="equipes[]"
    label="Equipes"
    :config="['placeholder' => 'Selecione as equipes']"
    multiple
    required
    fgroup-class="col-md-12"
>
    @foreach($equipes as $equipe)
        <option
            @if(in_array($equipe->id, $idsEquipe ?? []))) selected @endif
        value="{{ $equipe->id }}">{{ $equipe->nome }}</option>
    @endforeach

</x-adminlte-select2>
