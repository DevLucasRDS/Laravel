<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contas</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 4px 6px;
        }

        thead tr {
            background: #adb5bd;
        }

        tfoot tr {
            font-weight: bold;
            background: #f0f0f0;
        }

        td.text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Relatório de Contas</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Valor</th>
                <th>Vencimento</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contas as $conta)
            <tr>
                <td class="text-center">{{ $conta->id }}</td>
                <td class="text-center">{{ $conta->nome }}</td>
                <td class="text-center">R$ {{ number_format($conta->valor, 2, ',', '.') }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($conta->vencimento)->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center" style="color: red;">Nenhuma conta cadastrada.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="1" class="text-center">Total de Contas: {{ $tamanho }}</td>
                <td colspan="3" class="text-center">Valor Total: R$ {{ number_format($total, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>