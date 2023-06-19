@extends('layouts.main')

@section('title', 'Perfil Funcionario')

@section('content')

    <main id="main" class="main">

        <section class="section profile">

            <div class="row">
                <div class="pagetitle">
                    <h1>Perfil</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/portaria/listar">Portaria</a></li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->

                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            @if ($funcionario->imagem != null)
                                <img src="{{ asset('storage/' . $funcionario->imagem) }}" height="150px" alt="Profile"
                                    id="photo_ferfil" alt="Profile" class="rounded-circle">
                            @else
                                <img src="/img/perfilsemfoto.jpg" height="150px" alt="Profile" id="photo_ferfil"
                                    alt="Profile" class="rounded-circle">
                            @endif
                            <h2 class="text-capitalize">{{ $funcionario->Nome }}&nbsp;{{ $funcionario->Sobrenome }}</h2>
                            <h3 class="text-capitalize">{{ $funcionario->funcionario_tipo }}</h3>
                            <div class="social-links mt-2">
                                <a href="/funcionario/editar/{{ Auth()->user()->funcionario->id_funcionario }}"
                                    class="btn btn-primary">
                                    <i class="bi bi-file-earmark-person"></i></a>
                                <a href="#" class="twitter d-none"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="facebook d-none"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="instagram d-none"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin d-none"><i class="bi bi-linkedin"></i></a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xl-8">

                    <div class="card">
                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab"
                                        data-bs-target="#profile-overview">Perfil</button>
                                </li>

                                @can('isMotoristaOuCobrador', $funcionario)

                                    @if (count($TotaldeSaidasEntradas) > 0)
                                        <li class="nav-item">
                                            <button class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#entrada-saida">Entrada/saida</button>
                                        </li>
                                    @endif
                                @endcan

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <h5 class="card-title">Acerca do Funcionario</h5>
                                    <p class="small fst-italic">{{ $funcionario->descricao }}</p>

                                    <h5 class="card-title">Detalhes do Perfil</h5>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-success fs-5">
                                                <i class="bi bi-file-earmark-person"></i></span>Nome Completo
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $funcionario->Nome }}&nbsp;{{ $funcionario->Sobrenome }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-danger fs-5">
                                                <i class="bi bi-file-earmark-person"></i></span>Tipo de funcionario
                                        </div>
                                        <div class="col-lg-9 col-md-8 ">{{ $funcionario->funcionario_tipo }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-danger fs-5">
                                                <i class="bi bi-file-earmark-person"></i></span>MEC
                                        </div>
                                        <div class="col-lg-9 col-md-8">{{ $funcionario->numero_mecanografico }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-info fs-5">
                                                <i class="bi bi-pin-map-fill"></i></span>&nbsp;Base
                                        </div>
                                        <div class="col-lg-9 col-md-8">{{ $base[0]->nome_base }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-info fs-5">
                                                <i class="bi bi-pin-map-fill"></i></span>&nbsp;Provincia
                                        </div>
                                        <div class="col-lg-9 col-md-8">{{ $base[0]->nome_provincia }}</div>
                                    </div>


                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label"> <span class="text-info fs-5">
                                                <i class="bi bi-pin-map-fill"></i></span>&nbsp;Muncipio</div>
                                        <div class="col-lg-9 col-md-8">{{ $base[0]->nome_municipio }}</div>
                                    </div>


                                </div>

                                @can('isMotoristaOuCobrador', $funcionario)

                                    {{-- veificando se o exite algum registro de saida ou entrada --}}

                                    @if (count($TotaldeSaidasEntradas) > 0)
                                        <div class="tab-pane fade show entrada-saida" id="entrada-saida">

                                            <a class="text-dark" target="blank"
                                                href="/portaria/listar/TodasEntradasSaidasFuncionario/{{ $TotaldeSaidasEntradas[0]->$pefil }}">
                                                <div class="row P-2 fs-5">
                                                    <div class="col-lg-3 col-md-4 label">
                                                        <span class="text-dark fs-5">
                                                            <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de E/S
                                                    </div>
                                                    <div class="col-lg-9 col-md-8">
                                                        {{ count($TotaldeSaidasEntradas) }} </div>
                                                </div>
                                            </a>

                                            @if (count($TotalDeEntradas) > 0)
                                                <a class="text-dark" target="blank"
                                                    href="/portaria/listar/EntradasFuncionario/{{ $TotaldeSaidasEntradas[0]->$pefil }}">
                                                    <div class="row P-2 fs-5">
                                                        <div class="col-lg-3 col-md-4 label">
                                                            <span class="text-primary fs-5">
                                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de
                                                            Entradas
                                                        </div>
                                                        <div class="col-lg-9 col-md-8">
                                                            {{ count($TotalDeEntradas) }} </div>
                                                    </div>
                                                </a>
                                            @endif

                                            @if (count($TotalDeSaidas) > 0)
                                                <a class="text-dark" target="blank"
                                                    href="/portaria/listar/SaidasFuncionario/{{ $TotaldeSaidasEntradas[0]->$pefil }}">
                                                    <div class="row P-2 fs-5">
                                                        <div class="col-lg-3 col-md-4 label">
                                                            <span class="text-dark fs-5">
                                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de
                                                            Saidas
                                                        </div>
                                                        <div class="col-lg-9 col-md-8">
                                                            {{ count($TotalDeSaidas) }} </div>
                                                    </div>
                                                </a>
                                            @endif

                                            @if (count($TotalDeSaidas) > 0)
                                                <div class="row P-2 fs-5">
                                                    <div class="col-lg-3 col-md-4 label">
                                                        <span class="text-primary fs-5">
                                                            <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ultima Saida
                                                    </div>
                                                    <div class="col-lg-9 col-md-8">
                                                        {{ date('d/m/Y H:m:s', strtotime($Ultima_saida_Do_Veiculo[0]->dataHora)) }}
                                                    </div>
                                                </div>
                                            @endif

                                            @if (count($TotalDeEntradas) > 0)
                                                <div class="row P-2 fs-5">
                                                    <div class="col-lg-3 col-md-4 label">
                                                        <span class="text-primary fs-5">
                                                            <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ultima Entrada
                                                    </div>
                                                    <div class="col-lg-9 col-md-8">
                                                        {{ date('d/m/Y H:m:s', strtotime($Ultima_Entrada_Do_Veiculo[0]->dataHora)) }}
                                                    </div>
                                                </div>
                                            @endif

                                            @can('isCobrador', $funcionario)
                                                @if (count($TotalDeEntradas) > 0)
                                                    <div class="row P-2 fs-5">
                                                        <div class="col-lg-3 col-md-4 label">
                                                            <span class="text-primary fs-5">
                                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ultimo Motorista
                                                        </div>
                                                        <div class="col-lg-9 col-md-8">
                                                            {{ $Ultima_Entrada_Do_Veiculo[0]->motorista_nome }}
                                                            {{ $Ultima_Entrada_Do_Veiculo[0]->motorista_sobrenome }}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endcan

                                            @can('isMotorista', $funcionario)
                                                @if (count($TotalDeEntradas) > 0)
                                                    <div class="row P-2 fs-5">
                                                        <div class="col-lg-3 col-md-4 label">
                                                            <span class="text-primary fs-5">
                                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ultimo Cobrador
                                                        </div>
                                                        <div class="col-lg-9 col-md-8">
                                                            {{ $Ultima_Entrada_Do_Veiculo[0]->cobrador_nome }}
                                                            {{ $Ultima_Entrada_Do_Veiculo[0]->cobrador_sobrenome }}
                                                        </div>
                                                    </div>
                                                @endif
                                            @endcan

                                            @if (count($TotalDeEntradas) > 0)
                                                <div class="row P-2 fs-5">
                                                    <div class="col-lg-3 col-md-4 label">
                                                        <span class="text-dark fs-5">
                                                            <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ultimo
                                                        Supervisor
                                                    </div>
                                                    <div class="col-lg-9 col-md-8">
                                                        {{ $Ultima_Entrada_Do_Veiculo[0]->supervisor_nome }}
                                                        {{ $Ultima_Entrada_Do_Veiculo[0]->supervisor_sobrenome }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endcan

                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

@endsection

</body>

</html>
