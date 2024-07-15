@extends('layouts.app')

@section('title', 'Editar Cadastro')

@section('content')
<div class="container-fluid bg-light py-4">
    <div class="container bg-white p-4 rounded shadow">
        <h3 class="text-center mb-4">Editar Cadastro</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li class="error">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="editForm" action="{{ route('registers.update', $register->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" value="{{ $register->nome }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $register->email }}" required>
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" value="{{ $register->telefone }}" required maxlength="11">
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmModal">Salvar</button>
        </form>
    </div>

    <!-- Modal de confirmação -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirmar Edição</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja editar os dados?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirmEdit">Sim</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .error {
        color: red !important; /* Garante que fique vermelho */
        font-size: 0.9em; /* Tamanho menor */
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        // Adiciona uma validação personalizada para email
        $.validator.addMethod("validEmail", function(value, element) {
            return this.optional(element) || /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com|com\.br|br)$/.test(value);
        }, "Por favor, insira um email válido que termine em .com, .com.br ou .br.");

        // Adiciona uma validação personalizada para telefone
        $.validator.addMethod("validPhone", function(value, element) {
            return this.optional(element) || /^\d{10,11}$/.test(value);
        }, "Por favor, insira um telefone válido com 10 ou 11 dígitos.");

        $('#editForm').validate({
            rules: {
                nome: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    email: true,
                    validEmail: true,
                    maxlength: 255
                },
                telefone: {
                    required: true,
                    validPhone: true,
                    maxlength: 11,
                    digits: true
                }
            },
            messages: {
                nome: {
                    required: "Por favor, insira seu nome.",
                    maxlength: "O nome não pode ter mais de 255 caracteres."
                },
                email: {
                    required: "Por favor, insira seu email.",
                    email: "Por favor, insira um email válido.",
                    validEmail: "Por favor, insira um email que termine em .com, .com.br ou .br.",
                    maxlength: "O email não pode ter mais de 255 caracteres."
                },
                telefone: {
                    required: "Por favor, insira seu telefone.",
                    validPhone: "Por favor, insira um telefone válido com 10 ou 11 dígitos.",
                    maxlength: "O telefone não pode ter mais de 11 caracteres.",
                    digits: "Por favor, insira apenas números."
                }
            }
        });

        // Envia o formulário ao confirmar a edição
        document.getElementById('confirmEdit').addEventListener('click', function() {
            if ($('#editForm').valid()) {
                $('#editForm').submit();
            } else {
                $('#confirmModal').modal('hide');
            }
        });

        // Bloqueia a entrada de caracteres não numéricos no campo de telefone
        $('#telefone').on('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    });
</script>
@endsection
