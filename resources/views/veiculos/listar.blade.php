@extends('layouts.main')

@section('title', 'Listar veiculos')

@section('content')

    <div class="container my-5">

        <h2 class="text-center my-5 ">
            <i class="text-primary bi bi-list-columns"></i>
            lista de veiculos Cadastrados
        </h2>

        <div class="col-md-4 col-sm-6 mx-auto mb-5">

            <form class="d-flex" action="/veiculos/pesquisar" method="POST">
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
                <button class="btn btn-outline-primary" type="submit">Pesquisar</button>
            </form>

        </div>

        @if (isset($pesquisar))
            <div class="pagetitle me-2">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/veiculos/listar">listar</a></li>
                        <li class="breadcrumb-item"><a href="/cadastrar/veiculo">Cadastar</a></li>
                        <li class="breadcrumb-item active">veiculos</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
        @else
            <div class="pagetitle me-2">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/cadastrar/veiculo">Cadastar</a></li>
                        <li class="breadcrumb-item active">veiculos</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
        @endif

        <div class="card-header">

            <div class="row">

                <div class="col-6 text-center d-none">
                    <a href="/veiculos/gerarExel" class="me-2">
                        <button class="btn btn-sm btn-success ">Geral Exel</button>
                    </a>
                    <a target="_blank" href="/veiculos/gerarPDF" class="me-2">
                        <button class="btn btn-sm btn-success">Relatorio PDF</button>
                    </a>
                    <a href="/veiculos/cadastrar" class="me-2">
                        <button class="btn btn-sm btn-success">cadastrar</button>
                    </a>
                </div>

                <div class="col-6 mx-auto d-none">
                    <form class="d-flex" action="/veiculos/importar/exel" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input class="form-control form-control-sm me-2" type="file" name="arquivo">
                        <button class="btn btn-outline-success btn-sm" type="submit">Importar</button>
                    </form>
                </div>

            </div>
        </div>



        <div class="card-body table-responsive">

            <table class="table table-striped table-bordered datatable">

                <thead>
                    <tr>
                        <th>marca</th>
                        <th>prefixo</th>
                        <th>matricula</th>
                        <th>motor</th>
                        <th>chassis</th>
                        <th>lugares_sentados</th>
                        <th>lugares_em_pe</th>
                        <th>Lotação</th>
                        <th>ano</th>
                        <th>pais</th>
                        <th>kilometragem</th>
                        <th>situacao</th>
                        <th>Base</th>
                        <th>Perfil</th>
                        <th>Relatorio</th>
                        <th>editar</th>
                        <th>Deletar</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>marca</th>
                        <th>prefixo</th>
                        <th>matricula</th>
                        <th>motor</th>
                        <th>chassis</th>
                        <th>lugares_sentados</th>
                        <th>lugares_em_pe</th>
                        <th>Lotação</th>
                        <th>ano</th>
                        <th>pais</th>
                        <th>kilometragem</th>
                        <th>situacao</th>
                        <th>Base</th>
                        <th>Perfil</th>
                        <th>Relatorio</th>
                        <th>editar</th>
                        <th>Deletar</th>
                    </tr>
                </tfoot>
                <tbody>

                    @if (count($veiculos) > 0)

                        @foreach ($veiculos as $veiculo)
                            <tr>
                                <td>{{ $veiculo->marca }}</td>
                                <td>{{ $veiculo->prefixo }}</td>
                                <td>{{ $veiculo->matricula }}</td>
                                <td>{{ Str::limit($veiculo->motor, 8) }}</td>
                                <td>{{ Str::limit($veiculo->chassis, 8) }}</td>
                                <td>{{ $veiculo->lugares_sentados }}</td>
                                <td>{{ $veiculo->lugares_em_pe }}</td>
                                <td>{{ $veiculo->lotacao }}</td>
                                <td>{{ $veiculo->ano }}</td>
                                <td>{{ $veiculo->pais }}</td>
                                <td>{{ $veiculo->kilometragem }}</td>
                                <td>{{ $veiculo->situacao }}</td>
                                <td>{{ $veiculo->nome_base }}</td>

                                <td>
                                    <a href="/veiculo/perfil/{{ $veiculo->id_veiculo }}"
                                        class="text-dark btn btn-success ">
                                        <span class="text-white fs-5">
                                            <i class="bi bi-truck"></i></span>
                                    </a>
                                </td>

                                <td class="text-center" title="imprimir"><a class="btn btn-info fs-5"><i
                                            class="bi bi-file-earmark-pdf"></i></td></a>
                                </td>

                                <td class="text-center" title="Editar">
                                    <a class="btn btn-primary" href="/veiculo/editar/{{ $veiculo->id_veiculo }}"><i
                                            class="bi bi-pen-fill"></i>
                                </td></a>
                                <td class="text-center" title="Deletar">
                                    <form action="/veiculo/deletar/{{ $veiculo->id_veiculo }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
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
                    {!! $veiculos->appends([
                            'pesquisar' => request()->get('pesquisar', ''),
                        ])->links() !!}
                </ul>
            </nav>

        </div>

    </div>

@endsection
