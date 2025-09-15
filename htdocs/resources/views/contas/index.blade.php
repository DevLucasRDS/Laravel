@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-header d-flex justify-content-between">
        <span>Listar contas</span>
        <span>
            <a href="{{ route('contas.create')}}" class="btn btn-success btn-sm">Cadastrar</a>
        </span>
    </div>

    @if(session('success'))
    <div class="alert alert-success m-3" role="alert">
        {{ session('success')}}
    </div>
    @endif

    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Vencimento</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contas as $conta)
                <tr>
                    <th scope="row">{{ $conta->id }}</th>
                    <td>{{ $conta->nome }}</td>
                    <td>{{ ' R$ ' . number_format($conta-> valor, 2, ',', '.')}}</td>
                    <td>{{ \Carbon\Carbon::parse($conta->vencimento)->timezone('America/Sao_Paulo')->format('d/m/Y') }}</td>
                    <td class="d-md-flex justify-content-center">
                        <a href="{{ route('contas.show', ['conta' => $conta -> id]) }}">
                            <button type="button" class="btn btn-primary btn-sm me-1">Visualizar</button>
                        </a>
                        <a href="{{ route('contas.edit', ['conta' => $conta -> id]) }}">
                            <button type="button" class="btn btn-warning btn-sm me-1">Editar</button>
                        </a>

                        <form action="{{ route('contas.destroy', $conta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger  btn-sm me-1" onclick="return confirm('Tem certeza que deseja apagar esta conta?')">Apagar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <p style="color: red">Nenhuma conta cadastrada.</p>
                @endforelse

            </tbody>
        </table>
        {{$contas->onEachSide(0)->links()}}
    </div>
</div>
@endsection