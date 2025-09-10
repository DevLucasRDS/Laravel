<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Teste</title>
    </head>
    <body>
        <h1>Ola Mundo</h1>
        <a href="{{ route('contas.index') }}">Listar as contas</a>
        <a href="{{ route('contas.create') }}">Cadastrar</a>
        <a href="{{ route('contas.edit') }}">Editar Conta</a>
        <a href="{{ route('contas.show') }}">Mostrar Conta</a>
    </body>
</html>
