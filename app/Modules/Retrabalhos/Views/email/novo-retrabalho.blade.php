<x-mail::layout>
<x-slot:header>
    <x-mail::header url="{{config('app.url')}}">
        <img src="{{ asset(config('adminlte.logo_img')) }}"
             alt="{{ config('adminlte.logo_img_alt') }}" height="50">
    </x-mail::header>
</x-slot:header>
Prezado ***{{ $retrabalhoCasoTesteDTO->usuario->name }}***,
foi encontrado o seguinte retrabalho na tarefa ***{{ $retrabalhoCasoTesteDTO->numero_tarefa }}***, favor corrigir.

____
## Descrição:
{{ $retrabalhoCasoTesteDTO->descricao }}

@if($retrabalhoCasoTesteDTO->caso_teste)
____

## CASO DE TESTE \#{{ $retrabalhoCasoTesteDTO->caso_teste->id }}
____

### Título:

{!! strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->titulo),['<br />','<br>']) !!}
____
### Requisito:

{!! strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->requisito),['<br />','<br>']) !!}
____
### Cenário:

{!! strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->cenario),['<br />','<br>']) !!}

____
### Teste:

{!!  strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->teste),['<br />','<br>']) !!}

____
### Resultado esperado:

{!! strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->resultado_esperado),['<br />','<br>']) !!}

@endif
____

<x-slot:footer>
    <x-mail::footer>
        Retrabalho: \#{{ $retrabalhoCasoTesteDTO->id }} | Data de cadastro: {{ $retrabalhoCasoTesteDTO->data->format('d/m/Y') }}
    </x-mail::footer>
</x-slot:foot>
</x-mail::layout>
