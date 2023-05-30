<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- favicone -->
    <link rel="shortcut icon" href="/img/tcul_ico-300x116.png" type="image/x-icon">
    <!-- Bootstrap link  -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <!-- Bootstrap link icones  -->
    <link href="/assets/icones/font/bootstrap-icons.css" rel="stylesheet">
    <!-- My link -->
    <link rel="stylesheet" href="/css/style.css">
    {{-- <link href="/assets/simple-datatables/style.css" rel="stylesheet"> --}}
    <!--- select2 link -->
    <link href="/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/assets/plugins/Galeria/css_galeria/magnific-popup.css">
    <!-- Galeria -->
    <link rel="stylesheet" type="text/css" href="/assets/plugins/Galeria/css_galeria/style.css"><!-- Galeria -->

</head>

<body>
    <header>

        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            a {
                text-decoration: none;
            }

            .icon-badge-group .icon-badge-container {
                display: inline-block;
                margin-left: 15px;
            }

            .icon-badge-group .icon-badge-container:first-child {
                margin-left: 0
            }

            .icon-badge-container {
                margin-top: 20px;
                position: relative;
            }

            .icon-badge-icon {
                font-size: 20px;
                position: relative;
            }

            .icon-badge {
                background-color: red;
                font-size: 12px;
                color: white;
                text-align: center;
                width: 20px;
                height: 20px;
                border-radius: 35%;
                position: absolute;
                /* changed */
                top: -5px;
                /* changed */
                left: 18px;
                /* changed */
            }
        </style>

        </head>

        <body>

            <header class="mb-5">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                    <div class="container">

                        <a class="navbar-brand" href="/">
                            <img src="/img/tcul_ico-300x116.png" width="100px" height="40px"
                                class="d-inline-block align-top" alt="">
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">

                            <ul class="navbar-nav mx-auto">

                                @can('isAdmin', App\Models\Funcionario::class)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdown"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="fs-5 text-info">
                                                <i class="bi bi-pin-map-fill"></i>
                                            </div>
                                            Base
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="/cadastrar/base">
                                                    Cadastrar</a></li>
                                            <hr class="dropdown-divider">
                                            <li><a class="dropdown-item" href="/base/listar">
                                                    Listar</a></li>
                                            <hr class="dropdown-divider">
                                            <li><a class="dropdown-item" href="/cadastrar/provincia">
                                                    Adcionar Localidade</a></li>
                                            <hr class="dropdown-divider">
                                        </ul>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdown"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="fs-5 text-success">
                                                <i class="bi bi-file-earmark-person"></i>
                                            </div>
                                            funcionarios
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="/cadastrar/funcionario">
                                                    Cadastrar</a></li>
                                            <hr class="dropdown-divider">
                                            <li><a class="dropdown-item" href="/funcionario/listar/base">
                                                    Listar Minha Base</a></li>
                                            <hr class="dropdown-divider">
                                            <li><a class="dropdown-item" href="/funcionario/listar">
                                                    Listar</a></li>
                                            <hr class="dropdown-divider">
                                        </ul>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-center" href="#" id="navbarDropdown"
                                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="fs-5 text-primary">
                                                <i class="bi bi-truck"></i>
                                            </div>
                                            Veiculos
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="/cadastrar/veiculo">
                                                    Cadastrar</a></li>
                                            <hr class="dropdown-divider">
                                            <li><a class="dropdown-item" href="/veiculos/listar">
                                                    Listar</a></li>
                                            <hr class="dropdown-divider">
                                            <li><a class="dropdown-item" href="/veiculos/listar/base">
                                                    Listar Base</a></li>
                                            <hr class="dropdown-divider">
                                        </ul>
                                    </li>

                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle text-center" href="#"
                                            id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <div class="fs-5 text-warning">
                                                <i class="bi bi-ui-checks-grid"></i>
                                            </div>
                                            Ckecklist
                                        </a>
                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                            <li><a class="dropdown-item" href="/cadastrar/checklist">
                                                    Cadastrar</a></li>
                                            <hr class="dropdown-divider">
                                            <li><a class="dropdown-item" href="/checklist/listar">
                                                    Listar</a></li>
                                            <hr class="dropdown-divider">
                                        </ul>
                                    </li>
                                @endcan

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-center" href="#"
                                        id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <div class="fs-5 text-danger">
                                            <i class="bi bi-door-open-fill"></i>
                                        </div>
                                        portaria
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/cadastrar/portaria">
                                                Cadastrar</a></li>
                                        <hr class="dropdown-divider">
                                        <li><a class="dropdown-item" href="/portaria/listar">
                                                Listar Minhas Entradas/Saidas</a></li>
                                        <hr class="dropdown-divider">
                                        <li><a class="dropdown-item" href="/portaria/listar/base">
                                                Listar Base</a></li>
                                        <hr class="dropdown-divider">
                                    </ul>
                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-center" href="#"
                                        id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <div class="fs-5 text-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="28"
                                                fill="currentColor" class="bi bi-wrench-adjustable"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M16 4.5a4.492 4.492 0 0 1-1.703 3.526L13 5l2.959-1.11c.027.2.041.403.041.61Z" />
                                                <path
                                                    d="M11.5 9c.653 0 1.273-.139 1.833-.39L12 5.5 11 3l3.826-1.53A4.5 4.5 0 0 0 7.29 6.092l-6.116 5.096a2.583 2.583 0 1 0 3.638 3.638L9.908 8.71A4.49 4.49 0 0 0 11.5 9Zm-1.292-4.361-.596.893.809-.27a.25.25 0 0 1 .287.377l-.596.893.809-.27.158.475-1.5.5a.25.25 0 0 1-.287-.376l.596-.893-.809.27a.25.25 0 0 1-.287-.377l.596-.893-.809.27-.158-.475 1.5-.5a.25.25 0 0 1 .287.376ZM3 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                                            </svg>
                                        </div>
                                        Manutenção/OS
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="/os/listar">
                                                Ordem de Serviço</a></li>
                                        <hr class="dropdown-divider">
                                        <li><a class="dropdown-item" href="/manutencao/preventiva">
                                            Manutenção preventiva</a></li>
                                    <hr class="dropdown-divider">
                                        <li><a class="dropdown-item" href="/portaria/listar">
                                                Manutenções</a></li>
                                        <hr class="dropdown-divider">

                                    </ul>
                                </li>

                                <li class="nav-item dropdown">
                                    <div class="dropdown ">
                                        <a href="#"
                                            class="d-block link-primary text-decoration-none dropdown-toggle"
                                            id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">

                                            @if (Auth()->user()->funcionario->imagem != null)
                                                <img src="{{ asset('storage/' . Auth()->user()->funcionario->imagem) }}"
                                                    class="rounded-circle" alt="mdo" width="52"
                                                    height="52">
                                            @else
                                                <img src="/img/perfilsemfoto.jpg" alt="Profile"
                                                    class="rounded-circle" alt="mdo" width="52"
                                                    height="52">
                                            @endif

                                        </a>
                                        <ul class="dropdown-menu text-small" aria-labelledby="dropdownUser1">
                                            <li><a class="dropdown-item"
                                                    href="/funcionario/perfil/{{ Auth()->user()->funcionario->id_funcionario }}"
                                                    class="text-dark">Perfil</a></li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                  document.getElementById('logout-form').submit();">
                                                    Sair
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                            </ul>
                            </li>

                            <ul class="mx-auto">

                            </ul>

                            <!--
                        <ul class="text-center mt-2">
                            <li class="me-3">
                                <a class="text-white text-center" href="/paginas/sobre">
                                    <div class="icon-badge-container">
                                        <i class="far fa-envelope icon-badge-icon"></i>
                                        <div class="icon-badge">6</div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                        -->
                        </div>
                    </div>
                </nav>

            </header>

            {{-- O conteodo das paginas estara dentro da yield content --}}
            <main>
                <div class="container-fluid">
                    <div class="row">

                        {{-- verificando se existe a sessao mensagem --}}
                        @if (session('msg'))
                            <p class="alert alert-success mx-auto col-8 m-2 text-center fs-5">{{ session('msg') }}
                            </p>
                        @endif

                        @if (session('ERRO'))
                            <p class="alert alert-danger mx-auto col-8 m-2 text-center fs-5">{{ session('ERRO') }}
                            </p>
                        @endif

                         <!-- Elemento HTML para exibir a mensagem -->
                         <div class="alert alert-success mx-auto col-8 m-2 text-center fs-5" id="msg" style="display: none;"></div>

                        @yield('content')
 
                  </div>
                </div>
                <main>

                    <footer>
                        <p>Tcul &copy; </p>
                    </footer>

                    <script src="/js/jspdf.js"></script>
                    <script src="/js/script.js"></script>
                    <script src="/js/bootstrap.bundle.min.js"></script>    
                    <script src="https://printjs-4de6.kxcdn.com/print.min.css"></script>
                    <script type="text/javascript" src="/assets/plugins/select2/dist/js/jquery.js"></script>
                    <script type="text/javascript" src="/assets/plugins/select2/dist/js/select2.min.js"></script>
                    <script type="text/javascript" src="/js/funcoes.js"></script>
                    <script src="/js/meuscript.js"></script>
                    {{-- <script src="/assets/simple-datatables/simple-datatables.js"></script> --}}
                    <script type="text/javascript" src="/assets/plugins/Galeria\js_galeria/jquery.magnific-popup.js"></script><!-- Galeria 2ª link -->
                    <script type="text/javascript" src="/assets/plugins/Galeria/js_galeria/script.js"></script><!-- Galeria 3ª link -->

                    <script>
                        // Recupera a mensagem da sessão de JavaScript
                        var msg = sessionStorage.getItem('msg');

                        // Exibe a mensagem no elemento HTML e mostra o elemento
                        if (msg !== null && msg !== '') {
                            document.getElementById('msg').innerHTML = msg;
                            document.getElementById('msg').style.display = 'block';
                            
                            console.log(document.getElementById('msg'));
                        }

                        console.log(msg);

                    </script>
        </body>

</html>
