@extends('layouts.main')

@section('title', 'Manutenção preventiva Listar')

@section('content')

    <div class="container my-5">

        <h2 class="text-center my-5 ">
            <i class="text-secondary  bi bi-list-columns"></i>
            lista de OS
        </h2>

        <div class="col-md-4 col-sm-6 mx-auto mb-3">

            <form class="d-flex" action="/os/pesquisar" method="POST">
                @csrf
                <input name="pesquisar" type="search" placeholder="pesquisar" aria-label="Search"
                    class="form-control me-2
                @error('pesquisar') is-invalid @enderror"
                    value="{{ old('pesquisar') }}">
                @error('pesquisar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
                <button class="btn btn-outline-secondary" type="submit">Pesquisar</button>
            </form>

        </div>

        <div class="card-body table-responsive">

            <div class="row">

                @if (isset($pesquisar))
                    <div class="pagetitle">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="/os/listar">Listar</a></li>
                                <li class="breadcrumb-item"><a href="/os/criar">Criar OS</a></li>
                                <li class="breadcrumb-item active">OS</li>
                            </ol>
                        </nav>
                    </div><!-- End Page Title -->
                @else
                    <div class="col-6 text-center">
                        <a href="/os/criar" class="me-1">
                            <button class="btn btn-secondary ">Criar OS</button>
                        </a>

                    </div>
                @endif

            </div>

            <table class="table table-striped table-bordered datatable">
                <table class="table table-striped table-bordered datatable">
                    <thead>
                        <tr>
                            <th>Tipo de Manutenção</th>
                            <th>Veiculo</th>
                            <th>Matricula</th>
                            <th>Supervisor</th>
                            <th>Base</th>
                            <th>Previsão da Manutenção</th>
                            <th>Data</th>
                            <th>Imagens</th>
                            <th>editar</th>
                            <th>ver</th>
                            <th>Relatorio</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Tipo de Manutenção</th>
                            <th>Veiculo</th>
                            <th>Matricula</th>
                            <th>Supervisor</th>
                            <th>Base</th>
                            <th>Previsão da Manutenção</th>
                            <th>Data</th>
                            <th>Imagens</th>
                            <th>editar</th>
                            <th>ver</th>
                            <th>Relatorio</th>
                        </tr>
                    </tfoot>
                    <tbody>

                        @if (count($ManutencaoPreventiva) > 0)

                            @foreach ($ManutencaoPreventiva as $manutencao_preventiva)
                                <tr>
                                    <td>
                                        @if ( $manutencao_preventiva->tipo_manutencao == 'Mecânica')
                                            <span class="text-secondary fs-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                    fill="currentColor" class="bi bi-wrench-adjustable" viewBox="0 0 16 16">
                                                    <path
                                                        d="M16 4.5a4.492 4.492 0 0 1-1.703 3.526L13 5l2.959-1.11c.027.2.041.403.041.61Z" />
                                                    <path
                                                        d="M11.5 9c.653 0 1.273-.139 1.833-.39L12 5.5 11 3l3.826-1.53A4.5 4.5 0 0 0 7.29 6.092l-6.116 5.096a2.583 2.583 0 1 0 3.638 3.638L9.908 8.71A4.49 4.49 0 0 0 11.5 9Zm-1.292-4.361-.596.893.809-.27a.25.25 0 0 1 .287.377l-.596.893.809-.27.158.475-1.5.5a.25.25 0 0 1-.287-.376l.596-.893-.809.27a.25.25 0 0 1-.287-.377l.596-.893-.809.27-.158-.475 1.5-.5a.25.25 0 0 1 .287.376ZM3 14a1 1 0 1 1 0-2 1 1 0 0 1 0 2Z" />
                                                </svg>
                                            </span>
                                            {{ $manutencao_preventiva->tipo_manutencao }}
                                        @else
                                            <span class="text-danger fs-5">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25"
                                                    fill="currentColor" class="bi bi-lightning-charge" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09zM4.157 8.5H7a.5.5 0 0 1 .478.647L6.11 13.59l5.732-6.09H9a.5.5 0 0 1-.478-.647L9.89 2.41 4.157 8.5z" />
                                                </svg>
                                            </span>
                                            {{ $manutencao_preventiva->tipo_manutencao }}
                                        @endif

                                    </td>
                                    
                                    <td>
                                        <a href="/veiculo/perfil/{{ $manutencao_preventiva->id_veiculo }}" class="text-dark">
                                            <span class="text-primary fs-5">
                                                <i class="bi bi-credit-card-2-front"></i>
                                            </span>
                                            {{ $manutencao_preventiva->prefixo }}
                                        </a>
                                    </td>

                                    <td>
                                        <a href="/veiculo/perfil/{{ $manutencao_preventiva->id_veiculo }}" class="text-dark">
                                            <span class="text-primary fs-5">
                                                <i class="bi bi-credit-card-2-front"></i>
                                            </span>
                                            {{ $manutencao_preventiva->matricula }}
                                        </a>
                                    </td>

                                    <td>
                                        <a href="/funcionario/perfil/{{ $manutencao_preventiva->id_supervisor }}" class="text-dark">
                                            <span class="text-dark fs-5">
                                                <i class="bi bi-person-workspace"></i>
                                                {{ $manutencao_preventiva->supervisor_nome }}
                                                {{ $manutencao_preventiva->supervisor_sobrenome }}
                                          </a>
                                    </td>

                                    <td>
                                        <span class="text-success fs-5">
                                            <i class="bi bi-pin-map-fill"></i></span>
                                            {{ $manutencao_preventiva->nome_base }}
                                    </td>

                                    <td class="text-center">
                                        <span class="text-danger fs-5">
                                            <i class="bi bi-calendar2-week-fill"></i></span>
                                        {{ date('d/m/Y', strtotime($manutencao_preventiva->previsao_da_manutencao)) }}
                                    </td>

                                    <td class="text-center">
                                        <span class="text-warning fs-5">
                                            <i class="bi bi-calendar2-week-fill"></i></span>
                                        {{ date('d/m/Y', strtotime($manutencao_preventiva->created_at)) }}

                                        {{ date('H:m:s', strtotime($manutencao_preventiva->created_at)) }}
                                    </td>

                                <td class="text-center" title="Editar">
                                    <a class="btn btn-danger" href="/manutencao/preventiva/imagens/{{ $manutencao_preventiva->id_preventiva }}">
                                        <i class="bi bi-card-image"></i>
                                    <td class="text-center" title="Editar">
                                        <a class="btn btn-primary" href="/manutencao/preventiva/editar/{{ $manutencao_preventiva->id_preventiva }}">
                                            <i class="bi bi-pen-fill"></i>
                                    </td></a>
                                    
                                    </td></a>
                                    <td title=""><a class="btn btn-warning fs-5"
                                            href="/manutencao/preventiva/checklist/{{ $manutencao_preventiva->id_preventiva }}">
                                            <i class="bi bi-ui-checks-grid"></i></td></a>

                                    <td class="text-center" title="imprimir"><a class="btn btn-info fs-5"
                                            href="/manutencao/imprimir/{{ $manutencao_preventiva->id_preventiva }}" target="blanck"><i
                                                class="bi bi-file-earmark-pdf"></i></td></a>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan='15'>
                                    <div class="alert alert-danger mx-auto col-12 m-2 text-center fs-5">
                                        Nenhum resultado encontrado
                                    </div>
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        {!! $ManutencaoPreventiva->appends([
                                'pesquisar' => request()->get('pesquisar', ''),
                            ])->links() !!}
                    </ul>
                </nav>


        </div>


        </body>

        </html>


    @endsection
