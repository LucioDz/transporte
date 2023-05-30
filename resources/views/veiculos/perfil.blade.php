@extends('layouts.main')

@section('title', 'Perfil do Veiculo')

@section('content')

    <main id="main" class="main">


        <section class="section profile">

            <div class="row">
                <div class="pagetitle">
                    <h1>Perfil</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/veiculos/listar">veiculos</a></li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->

                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            @if ($veiculo[0]->imagem != null)
                                <img src="{{ Storage::disk('s3')->url($veiculo[0]->imagem) }}" height="150px" alt="Profile"
                                    id="photo_ferfil" alt="Profile" class="rounded-circle">
                            @else
                                <img src="/img/veiculo.png" height="150px" alt="Profile" id="photo_ferfil"
                                    alt="Profile" class="rounded-circle">
                            @endif
                            <h2>{{ $veiculo[0]->prefixo }}</h2>
                            <div class="social-links mt-2 d-none">
                                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
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

                                {{-- veificando se o veiculo ja realizou alguma saida ou entrada --}}
                                @if (count($TotaldeSaidasEntradasdoVeiculo) > 0)
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#entrada-saida">Entrada/saida</button>
                                    </li>
                                @endif

                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                    <h5 class="card-title">Acerca do veiculo</h5>
                                    <p class="small fst-italic">{{ $veiculo[0]->prefixo }}</p>

                                    <h5 class="card-title">Detalhes do Perfil</h5>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-primary  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Marca
                                        </div>


                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->marca }}</div>
                                    </div>


                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-8 label col-sm-12">
                                            <span class="text-dark fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Prefixo
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->prefixo }}</div>
                                    </div>


                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-primary  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Matricula
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->matricula }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-dark  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Modelo
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->modelo }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-primary  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Motor
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->motor }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-dark  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Chassis
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->chassis }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-dark  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Lugares em Pé
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->lugares_em_pe }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-primary  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Luagares Sentados
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->lugares_sentados }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-dark  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Chassis
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->lotacao }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-primary  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ano de fabricação
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->ano }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-dark  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Pais
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->pais }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-primary  fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;kilometragem
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->kilometragem }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label ">
                                            <span class="text-dark fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Situação
                                        </div>

                                        <div class="col-lg-9 col-md-8">
                                            {{ $veiculo[0]->situacao }}</div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-primary fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de Entradas
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ count($TotalDeEntradasdoVeiculo) }} </div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-dark fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de Saidas
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ count($TotalDeSaidasdoVeiculo) }} </div>
                                    </div>


                                </div>

                                {{-- veificando se o veiculo ja realizou alguma saida ou entrada --}}
                                @if (count($TotaldeSaidasEntradasdoVeiculo) > 0)

                                    <a class="text-dark" target="blank"
                                        href="/portaria/listar/TodasEntradasSaidasVeiculo/{{$id_veiculo}}}">

                                        <div class="tab-pane fade show entrada-saida" id="entrada-saida">
                                            <div class="row P-2 fs-5">
                                                <div class="col-lg-3 col-md-4 label">
                                                    <span class="text-primary fs-5">
                                                        <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de E/S
                                                </div>
                                                <div class="col-lg-9 col-md-8">
                                                    {{ count($TotaldeSaidasEntradasdoVeiculo) }} </div>
                                            </div>
                                    </a>

                                    <a class="text-dark" target="blank"
                                        href="/portaria/listar/EntradasVeciulo/{{$id_veiculo }}">

                                        <div class="row P-2 fs-5">
                                            <div class="col-lg-3 col-md-4 label">
                                                <span class="text-primary fs-5">
                                                    <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de
                                                Entradas
                                            </div>
                                            <div class="col-lg-9 col-md-8">
                                                {{ count($Ultima_Entrada_Do_Veiculo) }}
                                            </div>
                                        </div>

                                    </a>

                                    <a class="text-dark" target="blank"
                                        href="/portaria/listar/SaidasVeciulo/{{ $id_veiculo }}">

                                        <div class="row P-2 fs-5">
                                            <div class="col-lg-3 col-md-4 label">
                                                <span class="text-primary fs-5">
                                                    <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de Saidas
                                            </div>
                                            <div class="col-lg-9 col-md-8">
                                                {{ count($Ultima_saida_Do_Veiculo) }}
                                            </div>
                                        </div>

                                    </a>

                                    {{--  vefircando se exite registro de entrada --}}
                                    @if (count($Ultima_Entrada_Do_Veiculo) > 0)
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

                                      {{--  vefircando se exite aregistro de entrada --}}
                                    @if (count($Ultima_saida_Do_Veiculo) > 0)
                                        <div class="row P-2 fs-5">
                                            <div class="col-lg-3 col-md-4 label">
                                                <span class="text-dark fs-5">
                                                    <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ultima Saida
                                            </div>
                                            <div class="col-lg-9 col-md-8">
                                                {{ date('d/m/Y H:m:s', strtotime($Ultima_saida_Do_Veiculo[0]->dataHora)) }}
                                            </div>
                                        </div>
                                    @endif

                                {{--  vefircando se exite algun registro de entrada --}}
                                    @if (count($Ultima_Entrada_Do_Veiculo) > 0)
                                        <div class="row P-2 fs-5">
                                            <div class="col-lg-3 col-md-4 label">
                                                <span class="text-dark fs-5">
                                                    <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ultimo Motorista
                                            </div>
                                            <div class="col-lg-9 col-md-8">
                                                {{ $Ultima_Entrada_Do_Veiculo[0]->motorista_nome }}
                                                {{ $Ultima_Entrada_Do_Veiculo[0]->motorista_sobrenome }}
                                            </div>
                                        </div>
                                    @endif


                                @if (count($Ultima_Entrada_Do_Veiculo) > 0)
                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-dark fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ultimo Cobrador
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ $Ultima_Entrada_Do_Veiculo[0]->cobrador_nome }}
                                            {{ $Ultima_Entrada_Do_Veiculo[0]->cobrador_sobrenome }}
                                        </div>
                                    </div>
                                 @endif

                                 @if (count($Ultima_Entrada_Do_Veiculo) > 0)
                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-dark fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Ultimo Supervisor
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ $Ultima_Entrada_Do_Veiculo[0]->supervisor_nome }}
                                            {{ $Ultima_Entrada_Do_Veiculo[0]->supervisor_sobrenome }}
                                        </div>
                                    </div>
                                 @endif

                            </div>
                            @endif

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
