@extends('layouts.admin')

@section('content')

<div class="card mt-4 mb-4 border shadow"">
    <div class=" card-header d-flex justify-content-between">
    <span>Pesquisar</span>
</div>

<div class="card-body">
    <form action="{{ route('contas.index')}}">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <label class="form-label" for="nome">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control" value="{{$nome}}" placeholder="Digite o nome da conta">
            </div>
            <div class="col-md-3 col-sm-12">
                <label class="form-label" for="data_inicio">Data inicio</label>
                <input type="date" name="data_inicio" id="data_inicio" class="form-control" value="{{$data_inicio}}">
            </div>
            <div class="col-md-3 col-sm-12">
                <label class="form-label" for="data_fim">Data final</label>
                <input type="date" name="data_fim" id="data_fim" class="form-control" value="{{$data_fim}}">
            </div>
            <div class="col-md-3 col-sm-12 mt-3 pt-3">
                <button type="submit" class="btn btn-info btn-sm">Pesquisar</button>
                <a class="btn btn-warning btn-sm" href="{{route('contas.index')}}">Limpar</a>
            </div>
        </div>
    </form>
</div>
</div>

<div class=" card mt-4 mb-4 border shadow">
    <div class="card-header d-flex justify-content-between">
        <span>Listar contas</span>
        <span>
            <a href="{{ route('contas.create')}}" class="btn btn-success btn-sm">Cadastrar</a>
            <a href="{{ url('gerar-pdf-conta?' . request() ->getQueryString())}}" class="btn btn-info btn-sm">Gerar PDF</a>
            <a href="{{ url('gerar-csv-conta?' . request() ->getQueryString())}}" class="btn btn-success btn-sm">Gerar Excel</a>
        </span>
        </span>

    </div>

    <x-alert />

    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Vencimento</th>
                    <th scope="col">Situação</th>
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
                    <td>
                        <a href="{{ route('contas.change-situation', ['conta' => $conta-> id])}}">
                            <span class="badge text-bg-{{ $conta->situacaoConta->cor }}">
                                {{ $conta->situacaoConta->nome }}
                            </span>
                        </a>
                    </td>

                    <td class="d-md-flex justify-content-center">
                        <a href="{{ route('contas.show', ['conta' => $conta -> id]) }}">
                            <button type="button" class="btn btn-primary btn-sm me-1">Visualizar</button>
                        </a>
                        <a href="{{ route('contas.edit', ['conta' => $conta -> id]) }}">
                            <button type="button" class="btn btn-warning btn-sm me-1">Editar</button>
                        </a>

                        <form id="formExcluir{{$conta ->id}}" action="{{ route('contas.destroy', $conta->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger  btn-sm me-1" onclick="confirmarExclusao(event, '{{ $conta -> id}}' )">Apagar</button>
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