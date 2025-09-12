<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="{{route('contas.create')}}">Cadastrar</a>
    <h1>Listar as contas</h1>

@if(session('success'))
        <span style="color: 'green'">
        {{ session('success')}}
        </span>
    @endif

    @forelse($contas as $conta)
        ID: {{ $conta->id }} <br>
        Nome: {{ $conta->nome }} <br>
        Valor: {{ ' R$ ' . number_format($conta-> valor, 2, ',', '.')}} <br>
        Vencimento: {{ \Carbon\Carbon::parse($conta->vencimento)->timezone('America/Sao_Paulo')->format('d/m/Y') }} <br>

        <a href="{{ route('contas.show', ['conta' => $conta -> id]) }}">
            <button type="button">Visualizar</button>
        </a>
        <a href="{{ route('contas.edit', ['conta' => $conta -> id]) }}">
             <button type="button">Editar</button>
        </a>

     <form action="{{ route('contas.destroy', $conta->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Tem certeza que deseja apagar esta conta?')">Apagar</button>
     </form>
     
        <hr>
        @empty
            <p style="color: red">Nenhuma conta cadastrada.</p>
    @endforelse
</body>
</html>