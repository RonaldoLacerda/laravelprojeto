@extends('layouts.app')

@section('title', 'Listagem de Cadastros')

@section('content')
<div class="container-fluid bg-light py-4">
    <div class="container bg-white p-4 rounded shadow">
        <h3 class="text-center mb-5 mt-2"><strong>Cadastros</strong></h3>

        <!-- Mensagem de sucesso -->
        <div class="text-center mb-3">
            @if (session('success'))
                <div id="successMessage" class="alert alert-success alert-dismissible fade show rounded-pill" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registers as $register)
                        <tr id="row{{ $register->id }}">
                            <td>{{ $register->id }}</td>
                            <td>{{ $register->nome }}</td>
                            <td>{{ $register->email }}</td>
                            <td>
                                @if (strlen($register->telefone) == 11)
                                    {{ preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $register->telefone) }}
                                @elseif (strlen($register->telefone) == 10)
                                    {{ preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $register->telefone) }}
                                @else
                                    {{ $register->telefone }} 
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('registers.edit', $register->id) }}" class="btn btn-sm btn-primary" title="Editar">
                                    <i class="fas fa-edit fa-sm"></i>
                                </a>
                                <button class="btn btn-sm btn-danger" title="Excluir" data-toggle="modal" data-target="#deleteModal{{ $register->id }}">
                                    <i class="fas fa-trash fa-sm"></i>
                                </button>
                            </td>
                        </tr>
                
                        <!-- Modal de confirmação -->
                        <div class="modal fade" id="deleteModal{{ $register->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $register->id }}" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $register->id }}">Confirmar Exclusão</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja excluir o cadastro de {{ $register->nome }}?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-danger" onclick="deleteRegister({{ $register->id }})">Excluir</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                
                    @if ($registers->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Nenhum cadastro encontrado.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Total de registros -->
        <hr>
        <div class="d-flex justify-content-start">
            <p><small>Total de registros: {{ $registers->total() }}</small></p>
        </div>

        <!-- Paginação -->
        <div class="d-flex justify-content-center">
            {{ $registers->links('vendor.pagination.bootstrap-4') }}
        </div>
        
    </div>
    <br>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    // Esconder a mensagem após 5 segundos
    setTimeout(function() {
        const message = document.getElementById('successMessage');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000);

    function deleteRegister(id) {
        $.ajax({
            url: '/registro/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#row' + id).remove();
                $('#successMessage').remove(); // Remove mensagens antigas
                $('div.text-center.mb-3').prepend('<div id="successMessage" class="alert alert-success alert-dismissible fade show rounded-pill" role="alert">' + response.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
                $('#deleteModal' + id).modal('hide');
                $('.modal-backdrop').remove(); // Remove backdrop se ainda estiver presente
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON ? xhr.responseJSON.error : 'Ocorreu um erro ao tentar excluir o cadastro.';
                alert(errorMessage);
            }
        });
    }

    // Script para fechar o navbar no mobile
    $(document).ready(function () {
        $('.navbar-nav>li>a').on('click', function(){
            $('.navbar-collapse').collapse('hide');
        });
    });
</script>
<style>
    .modal {
        z-index: 1050 !important;
    }
</style>
@endsection
@endsection
