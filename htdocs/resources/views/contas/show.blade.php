<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Listar as contas</h1>
    <a href="{{ route('contas.index') }}">Listar as contas</a>
    <a href="{{ route('contas.create') }}">Cadastrar</a>

    @if(session('success'))
        <span style="color: 'green'">
        {{ session('success')}}
        </span>
    @endif

    <br> ID: {{ $conta->id }} <br>
    Nome: {{ $conta->nome }} <br>
    Valor: {{ ' R$ ' . number_format($conta-> valor, 2, ',', '.')}} <br>
    Vencimento: {{ \Carbon\Carbon::parse($conta->vencimento)->timezone('America/Sao_Paulo')->format('d/m/Y') }} <br>
    Data de criação: {{ \Carbon\Carbon::parse($conta->created_at)->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }} <br>
    Data atualizada : {{ \Carbon\Carbon::parse($conta->updated_at)->timezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }}

</body>
</html>