@extends('layouts.email')

@section('content')
    <p>Olá,</p>

    <p>Contas a pagar de hoje:</p>

  @foreach($contas as $conta)
     - <strong>
        <a href="{{ route('contas.show', ['conta' => $conta->id]) }}" style="text-decoration: none">
            {{ $conta->nome }}
        </a>
        </strong>
        : R$ {{ number_format($conta->valor, 2, ',', '.') }} -
        {{ $conta->situacaoConta->nome ?? 'Situação não encontrada' }} -
        {{ \Carbon\Carbon::parse($conta->vencimento)->format('d/m/Y') }}
        <br>
    @endforeach
@endsection
