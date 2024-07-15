@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<div class="container-fluid bg-light py-4">
    <div class="container bg-white p-4 rounded shadow">
        <h3 class="text-center m-4"><strong>Seja bem-vindo!</strong></h3>
        <p class="text-center">Você está na página principal do sistema de cadastros de pessoas. Use o menu para acessar as opções disponíveis.</p>

        <div class="text-center">
            <a href="{{ route('registers.new') }}" class="btn btn-success m-2">
                <i class="fas fa-plus"></i> Novo Cadastro
            </a>
            <a href="{{ route('registers.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i> Ver Cadastros
            </a>
        </div>
    </div>
</div>
@endsection