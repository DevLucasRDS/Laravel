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

    @forelse($contas as $conta)
        <p>
        ID: {{ $conta->id }} <br>
        Nome: {{ $conta->nome }} <br>
        Valor: {{ ' R$ ' . number_format($conta-> valor, 2, ',', '.')}} <br>
        Vencimento: {{ \Carbon\Carbon::parse($conta->vencimento)->timezone('America/Sao_Paulo')->format('d/m/Y') }} <br>

        <a href="{{ route('contas.show', ['conta' => $conta-> id]) }}">Visualizar</a>
        <a href="{{ route('contas.edit', ['conta' => $conta-> id]) }}">Editar</a>

        </p>
        <hr>
        @empty
            <p style="color: red">Nenhuma conta cadastrada.</p>
    @endforelse
</body>
</html>