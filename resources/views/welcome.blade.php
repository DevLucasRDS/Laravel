@extends('layouts.admin')

@section('content')

<a href="{{ route('contas.index') }}">Listar as contas</a>
<a href="{{ route('contas.create') }}">Cadastrar</a>

@endsection