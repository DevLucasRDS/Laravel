@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-header d-flex justify-content-between">
        <span>Editar conta</span>
        <span>
            <a href="{{ route('contas.index')}}" class="btn btn-primary btn-sm me-1">Listar</a>
            <a href="{{ route('contas.show', ['conta' => $conta-> id])}}" class="btn btn-warning btn-sm me-1">Visualizar</a>
        </span>
    </div>

    <x-alert />

    <div class="card-body">
        <form class="row g-3" action="{{ route('contas.update', $conta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="col-md-12 col-sm-4">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control"
                    value="{{ old('nome', $conta->nome) }}">
            </div>

            <div class="col-md-4 col-sm-12">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" name="valor" id="valor" class="form-control"
                    value="{{ old('valor', isset($conta->valor) ? number_format($conta->valor, 2, ',', '.') : '') }}">
            </div>

            <div class="col-md-4 col-sm-12">
                <label for="vencimento" class="form-label">Vencimento</label>
                <input type="date" name="vencimento" id="vencimento" class="form-control"
                    value="{{ old('vencimento', $conta->vencimento) }}">
            </div>

            <div class="col-md-4 col-sm-12">
                <label for="situacao_conta_id" class="form-label">Situação</label>
                <select name="situacao_conta_id" id="situacao_conta_id" class="form-select select2">
                    <option value="">Selecione</option>
                    @forelse($situacoesContas as $situacaoConta)
                    <option value="{{ $situacaoConta->id }}"
                        {{ old('situacao_conta_id', $conta->situacao_conta_id) == $situacaoConta->id ? 'selected' : '' }}>
                        {{ $situacaoConta->nome }}
                    </option>
                    @empty
                    <option value="">Nenhuma situação da conta encontrada</option>
                    @endforelse
                </select>

            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-warning btn-sm">Atualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection