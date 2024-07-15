@extends('layouts.app')

@section('title', 'Novo Registro')

@section('content')

<div class="container-fluid bg-light py-4">
    <div class="container bg-white p-4 rounded shadow">
        <h3 class="text-center mb-4">Novo Registro</h3>

        {{-- Mensagem de sucesso --}}
        <div id="message" class="d-none alert p-1 m-1 rounded-pill text-center"></div>

        {{-- Formulário --}}
        <form id="registerForm" name="formNew">
            @csrf
            <div class="form-group">
                <label for="nome">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required value="{{ old('nome') }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="text" class="form-control" id="telefone" name="telefone" required value="{{ old('telefone') }}" maxlength="11">
            </div>
            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Salvar</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $(function () {
        function closeMessage() {
            $('#message').hide();
        }

        function checkFormValidity() {
            var form = $('#registerForm');
            $('#submitBtn').prop('disabled', !form.valid());
        }

        $('#registerForm').on('input', function() {
            closeMessage();
            checkFormValidity();
        });

        $('form[name="formNew"]').submit(function(event) {
            event.preventDefault();

            if (!$(this).valid()) {
                return;
            }

            $.ajax({
                url: "{{ route('registers.store') }}",
                type: "post",
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#message')
                            .removeClass('d-none alert-danger')
                            .addClass('alert-success')
                            .text(response.message)
                            .show();

                        $('#registerForm')[0].reset();
                        $('.error').text('');

                        setTimeout(closeMessage, 3000);
                        $('#submitBtn').prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('#message')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .show();

                    $.each(errors, function(key, value) {
                        $('label.error[for="' + key + '"]').text(value);
                    });
                }
            });
        });

        // Validação do formulário
        $('#registerForm').validate({
            rules: {
                nome: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 255
                },
                telefone: {
                    required: true,
                    maxlength: 11,
                    minlength: 10,
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
                    maxlength: "O email não pode ter mais de 255 caracteres."
                },
                telefone: {
                    required: "Por favor, insira seu telefone.",
                    maxlength: "O telefone não pode ter mais de 11 caracteres.",
                    minlength: "O telefone não pode ter menos de 10 caracteres.",
                    digits: "Por favor, insira apenas números."
                }
            }
        });

        // Desabilita o botão de submit inicialmente
        $('#submitBtn').prop('disabled', true);

        // Verifica a validade do formulário a cada entrada de dados
        $('#registerForm input').on('keyup input', function() {
            checkFormValidity();
        });

        // Bloqueia a entrada de caracteres não numéricos no campo de telefone
        $('#telefone').on('input', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    });
</script>

<style>
    .error {
        color: red !important;
        font-size: 0.9em;
    }
</style>

@endsection
