@extends('layouts.main')

@section('title', 'Perfil Base')

@section('content')

    <main id="main" class="main">

        <section class="section profile">

            <div class="row">
                <div class="pagetitle">
                    <h1>Perfil</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/base/listar">bases</a></li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->

                <div class="col-xl-4">

                    <div class="card">
                        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                            @if ($base[0]->imagem != null)
                                <img src="{{ Storage::disk('s3')->url($base[0]->imagem) }}" height="150px" alt="Profile"
                                    id="photo_ferfil" alt="Profile" class="rounded-circle">
                            @else
                                <img src="/img/perfilsemfoto.jpg" height="150px" alt="Profile" id="photo_ferfil"
                                    alt="Profile" class="rounded-circle">
                            @endif
                            <h2>{{ $base[0]->nome_base }}</h2>
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
                            </ul>
                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                    <h5 class="card-title">Acerca da base</h5>

                                    <p class="small fst-italic">
                                        {{ $base[0]->nome_base }}
                                    </p>

                                    <h5 class="card-title">Detalhes do Perfil</h5>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-8 label col-sm-12">
                                            <span class="text-dark fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;
                                                 Total de Veiculos
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ count($TotaldeoVeiculodaBase) }} </div>
                                    </div>

                                    
                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-8 label col-sm-12">
                                            <span class="text-dark fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;
                                                Funcionarios
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ count($TotaldeoFunionariosdaBase) }} </div>
                                    </div>

                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-primary fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de Entradas
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ count($TotaldeEntradas) }} </div>
                                    </div>
                                    
                                    <div class="row P-2 fs-5">
                                        <div class="col-lg-3 col-md-4 label">
                                            <span class="text-dark fs-5">
                                                <i class="bi bi-dash-circle-fill"></i></span>&nbsp;Total de Saidas
                                        </div>
                                        <div class="col-lg-9 col-md-8">
                                            {{ count($TotaldeSaidas) }} </div>
                                    </div>

                                </div>

                                {{-- veificando se o veiculo ja realizou alguma saida ou entrada --}}
                            
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
