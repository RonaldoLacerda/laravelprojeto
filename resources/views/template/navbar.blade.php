<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" style="width: 60px; height: auto;" class="img-fluid">
    </a>
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('registers.new') }}">Novo Cadastro</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/registros') }}">Cadastros</a>
            </li>
            <!-- Adicione mais itens de navegação conforme necessário -->
        </ul>
    </div>
</nav>

<style>
.navbar-nav .nav-link {
    color: black; /* Cor padrão */
    transition: color 0.3s;
}

.navbar-nav .nav-link:hover {
    color: #0056b3 !important; /* Cor ao passar o mouse */
    text-decoration: underline; /* Efeito de sublinhado */
}

.navbar-light .navbar-nav .nav-link.active {
    font-weight: bold; /* Destaque para a opção ativa */
    color: #0056b3; /* Cor da opção ativa */
}
</style>
