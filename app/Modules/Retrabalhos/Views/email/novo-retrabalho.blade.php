<x-mail::message>
Prezado {{ $retrabalhoCasoTesteDTO->usuario->name }},
foi encontrado o seguinte retrabalho na tarefa {{ $retrabalhoCasoTesteDTO->numero_tarefa }}, favor corrigir.
------
## Descrição:

{{ $retrabalhoCasoTesteDTO->descricao }}
---
@if($retrabalhoCasoTesteDTO->caso_teste)
## CASO DE TESTE \#{{ $retrabalhoCasoTesteDTO->caso_teste->id }}
---
### Título:
{!! strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->titulo),['<br />','<br>']) !!}
---
### Requisito:
{!! strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->requisito),['<br />','<br>']) !!}
---
### Cenário:
{!! strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->cenario),['<br />','<br>']) !!}
---
### Teste:
{!!  strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->teste),['<br />','<br>']) !!}
---
### Resultado esperado:
{!! strip_tags(nl2br($retrabalhoCasoTesteDTO->caso_teste->resultado_esperado),['<br />','<br>']) !!}
---
@endif
---
Retrabalho: \#{{ $retrabalhoCasoTesteDTO->id }} | Data de cadastro: {{ $retrabalhoCasoTesteDTO->data->format('d/m/Y') }}
</x-mail::message>
