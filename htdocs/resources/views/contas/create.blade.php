<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script defer src="{{ asset('js/custom.js') }}"></script>
</head>

<body>
    <h1>Cadastrar a contas</h1>

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            {{ $error }} <br>
            @endforeach
        </ul>
    </div>
    @endif

    <a href="{{ route('contas.index') }}">Listar as contas</a>

    <form action="{{ route('contas.store') }}" method="POST">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome') }}">

        <br>

        <label for="valor">Valor:</label>
        <input type="text" name="valor" id="valor" value="{{ old('valor') }}">

        <br>

        <label for="vencimento">Vencimento:</label>
        <input type="date" name="vencimento" id="vencimento" value="{{ old('vencimento') }}">

        <br>
        <button type="submit">Cadastrar</button>
    </form>

</body>

</html>