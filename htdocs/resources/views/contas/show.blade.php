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
        <a href="{{ route('contas.edit') }}">Editar Conta</a>
</body>
</html>