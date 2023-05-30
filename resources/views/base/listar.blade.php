@extends('layouts.main')

@section('title', 'Lista de Bases')

@section('content')

    <div class="container my-5">

        <h2 class="text-center my-5 ">
            <i class="text-info bi bi-list-columns"></i>
            lista das Bases Cadastrados
        </h2>

        <div class="col-md-4 col-sm-6 mx-auto mb-3">

            <form class="d-flex" action="/base/pesquisar" method="POST">
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
                <button class="btn btn-outline-info" type="submit">Pesquisar</button>
            </form>

        </div>

        <div class="card-body table-responsive">
            @if (isset($pesquisar))

            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/base/listar">listar</a></li>
                        <li class="breadcrumb-item"><a href="/cadastrar/base">Cadastar</a></li>
                        <li class="breadcrumb-item active">base</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            @else

            <div class="pagetitle">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/cadastrar/base">Cadastar</a></li>
                        <li class="breadcrumb-item active">base</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

        @endif
        
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>Nome Da base</th>
                        <th>Provincia</th>
                        <th>Municipio</th>
                        <th>Perfil</th>
                        <th>Relatorio</th>
                        <th>editar</th>
                        <th>Deletar</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nome Da base</th>
                        <th>Provincia</th>
                        <th>Municipio</th>
                        <th>Perfil</th>
                        <th>Relatorio</th>
                        <th>editar</th>
                        <th>Deletar</th>
                    </tr>
                </tfoot>
                <tbody>

                    @if (count($Bases) > 0)

                        @foreach ($Bases as $base)
                            <tr>
                                <td>{{ $base->nome_base }}</td>
                                <td>{{ $base->nome_provincia }}</td>
                                <td>{{ $base->nome_municipio }}</td>

                                <td>
                                    <a href="/base/perfil/{{ $base->id_base }}" class="text-dark btn btn-primary text-center">
                                        <span class="text-white fs-5">
                                            <i class="bi bi-pin-map-fill"></i></span>
                                    </a>
                                </td>

                                <td class="text-center" title="imprimir"><a class="btn btn-info fs-5"><i
                                            class="bi bi-file-earmark-pdf"></i></td></a>
                                </td>

                                <td class="text-center" title="Editar">
                                    <a class="btn btn-primary" href="/base/editar/{{ $base->id_base }}"><i
                                            class="bi bi-pen-fill"></i>
                                </td></a>

                                <td class="text-center" title="Deletar">
                                    <form action="/base/deletar/{{ $base->id_base }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"><i class="bi bi-trash"></i></button>

                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan='9'>
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
                    {!! $Bases->appends([
                            'pesquisar' => request()->get('pesquisar', ''),
                        ])->links() !!}
                </ul>
            </nav>

        </div>

    </div>

@endsection
