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

    @if(session('success'))
    <div class="alert alert-success m-3" role="alert">
        {{ session('success')}}
    </div>
    @endif

    @if ($errors->any())
    <div style="color: red;">
        <div class="alert alert-danger m-3">
            @foreach ($errors->all() as $error)
            {{ $error }} <br>
            @endforeach
        </div>
    </div>
    @endif


    <div class="card-body">
        <form class="row g-3" action="{{ route('contas.update', $conta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="col-12">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control"
                    value="{{ old('nome', $conta->nome) }}">
            </div>

            <div class="col-12">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" name="valor" id="valor" class="form-control"
                    value="{{ old('valor', isset($conta->valor) ? number_format($conta->valor, 2, ',', '.') : '') }}">
            </div>

            <div class="col-12">
                <label for="vencimento" class="form-label">Vencimento</label>
                <input type="date" name="vencimento" id="vencimento" class="form-control"
                    value="{{ old('vencimento', $conta->vencimento) }}">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-warning btn-sm">Atualizar</button>
            </div>
        </form>
    </div>
</div>
@endsection