@extends('layouts.admin')

@section('content')
<div class="card mt-4 mb-4 border shadow">
    <div class="card-header d-flex justify-content-between">
        <span>Cadastrar conta</span>
        <span>
            <a href="{{ route('contas.index')}}" class="btn btn-primary btn-sm me-1">Listar</a>
        </span>
    </div>

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
        <form class="row g-3" action="{{ route('contas.store')}}" method="POST">
            @csrf

            <div class="col-12">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" name="nome" id="nome" class="form-control"
                    value="{{ old('nome')}}">
            </div>

            <div class="col-12">
                <label for="valor" class="form-label">Valor</label>
                <input type="text" name="valor" id="valor" class="form-control"
                    value="{{ old('valor') }}">
            </div>

            <div class="col-12">
                <label for="vencimento" class="form-label">Vencimento</label>
                <input type="date" name="vencimento" id="vencimento" class="form-control"
                    value="{{ old('vencimento')}}">
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-sm">Cadastrar</button>
            </div>
        </form>
    </div>
</div>
@endsection