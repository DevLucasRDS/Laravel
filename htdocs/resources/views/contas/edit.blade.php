<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script defer src="{{ asset('js/custom.js') }}"></script>
</head>

<body>
    <h1>Editar conta</h1>
    <a href="{{ route('contas.create') }}">Cadastrar</a>
    <a href="{{ route('contas.index') }}">Listar as contas</a>

    @if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
            {{ $error }} <br>
            @endforeach
        </ul>
    </div>
    @endif
    @if(session('error'))
    <span style="color: 'red'">
        {{ session('error')}}
    </span>
    @endif

    <form action="{{ route('contas.update', $conta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="{{ old('nome', $conta->nome) }}">
        <br>

        <label for="valor">Valor:</label>
        <input type="text" name="valor" id="valor" value="{{ old('valor', isset($conta->valor) ? number_format ( $conta->valor, '2',',', '.' ) : '') }}">
        <br>

        <label for="vencimento">Vencimento:</label>
        <input type="date" name="vencimento" id="vencimento" value="{{ old('vencimento', $conta->vencimento) }}">
        <br>

        <button type="submit">Atualizar</button>
    </form>


</body>

</html>