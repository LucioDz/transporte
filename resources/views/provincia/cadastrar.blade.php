@extends('layouts.main')

@section('title', 'Provincia cadastrar')

@section('content')

    <style>
        input.larger {

            width: 22px;
            height: 22px;

        }

        .linha {
            border: 4px solid #FF0000;
            border-radius: 5px;
            font-weight: bolder;
        }

    </style>

    <div class="container my-5">

        <main id="main" class="main">

            <div class="pagetitle">
                <h1 class="text-center"> <i class="bi bi-pin-map-fill text-info"></i>Provincia</h1>
            </div><!-- End Page Title -->
            <section class="section">

                <div class="row my-5">

                    <div class="col-lg-6 mx-auto ">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Adicione uma Provincia</h5>
                                <!-- General Form Elements -->
                                <form name="add-car" method="POST" action="/provincia/cadastrar">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Nome </label>
                                        <div class="col-sm-10 ">
                                            <input type="text" name="nome_provincia" value="{{ old('nome_provincia') }}"
                                                class="form-control @error('nome_provincia') is-invalid @enderror">
                                            @error('nome_provincia')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Municipios </label>
                                        <div class="col-sm-8">

                                        </div>
                                        <div class="col-sm-2 p-1 mb-1 text-center">
                                            <button class="btn btn-outline-info btn-sm" type="button" onclick="provicnia()"
                                                title="adiconar">
                                                <i class="bi bi-plus-square"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="row mb-3 text-center">
                                        <div class="col-sm-10">
                                            <button type="button" class="btn btn-info"
                                                onclick="mostrar_cadastrar()">Cadastrar</button>
                                        </div>
                                    </div>

                                    {{-- Modal enviar dados --}}

                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">salvar dados</h5>
                                                    <button type="button" class="close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Deseja Realmente Salvar os dados
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- fim Modal enviar dados --}}
                                </form>
                            </div>
                        </div>

                        {{-- tabela - --}}
                        <div class="col-lg-12 mx-auto my-5">

                            <div class="pagetitle">
                                <h4 class="text-center"> <i class="bi bi-pin-map-fill text-info"></i> Lista de Provincias
                                    Registradas</h4>
                            </div><!-- End Page Title -->

                            <div class="card-body table-responsive">
                                @if (isset($pesquisar))
                                    <div class="pagetitle">
                                        <nav>
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/checklist/listar">checklist</a></li>
                                                <li class="breadcrumb-item active">listar</li>
                                            </ol>
                                        </nav>
                                    </div><!-- End Page Title -->
                                @endif
                                <table class="table table-striped table-bordered datatable">


                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Nome</th>
                                            <th>editar</th>
                                            <th>Deletar</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>id</th>
                                            <th>Nome</th>
                                            <th>editar</th>
                                            <th>Deletar</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        @if (count($provincias) > 0)

                                            @foreach ($provincias_pais as $prov)
                                                <tr>
                                                    <td>{{ $prov->id_provincia }}</td>
                                                    <td>{{ $prov->nome_provincia }}</td>

                                                    <td class="text-center" title="Editar">
                                                        <a class="btn btn-primary"
                                                            href="/provincia/editar/{{ $prov->id_provincia }}"><i
                                                                class="bi bi-pen-fill"></i>
                                                    </td></a>
                                                    <td class="text-center" title="Deletar">
                                                        <form action="/provincia/deletar/{{ $prov->id_provincia }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="bi bi-trash"></i></button>
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
                                        {!! $provincias_pais->appends([
        'pesquisar' => request()->get('pesquisar', ''),
    ])->links() !!}
                                    </ul>
                                </nav>

                            </div>
                            {{-- tabela - --}}

                            <div></div>

                        </div>

                    </div>

                    <!---  segunda coluna   --->
                    <div id="coluna" class="col-lg-6 mx-auto @if (old('enviar') != null) d-block @else d-none @endif">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-map-fill text-info"></i> Adicione um muncipio a
                                    sua provincia
                                    <!-- General Form Elements -->
                                    <form method="POST" action="/municipo/cadastrar" name="formulario">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="inputText" class="col-sm-2 col-form-label">Provincia</label>
                                            <div class="col-sm-8">
                                                <select id="provincia" name="id_provincia"
                                                    class="form-select @error('id_provincia') is-invalid @enderror">
                                                    <option value=""></option>
                                                    @foreach ($provincias as $provincia)
                                                        <option value="{{ $provincia->id_provincia }}">
                                                            {{ $provincia->nome_provincia }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_provincia')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="row mb-3">
                                            <label for="inputText" class="col-sm-2 col-form-label">Municipios</label>
                                            <div class="col-sm-10 ">
                                                <input type="text" name="nome_municipio" value="{{ old('nome_municipio') }}"
                                                    class="form-control @error('nome_municipio') is-invalid @enderror">
                                                @error('nome_municipio')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="row mb-3 text-center">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-info" name="enviar"
                                                    value="enviar">Cadastrar</button>
                                            </div>
                                        </div>
                                    </form>
                            </div>
                        </div>

                        <div class="col-lg-12 mx-auto my-5">

                            <div class="pagetitle">
                                <h4 class="text-center"> <i class="bi bi-pin-map-fill text-info"></i>Lista de Provincias
                                    e Municipios Registradas</h4>
                            </div><!-- End Page Title -->

                            <div class="card-body table-responsive">
                                @if (isset($pesquisar))
                                    <div class="pagetitle">
                                        <nav>
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="/checklist/listar">checklist</a></li>
                                                <li class="breadcrumb-item active">listar</li>
                                            </ol>
                                        </nav>
                                    </div><!-- End Page Title -->
                                @endif
                                <table class="table table-striped table-bordered datatable">


                                    <thead>
                                        <tr>
                                            <th>Muncipio</th>
                                            <th>Provincia</th>
                                            <th>editar</th>
                                            <th>Deletar</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Muncipios</th>
                                            <th>Provincia</th>
                                            <th>editar</th>
                                            <th>Deletar</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        @if (count($muncipios_provincias) > 0)

                                            @foreach ($muncipios_provincias as $prov)
                                                <tr>
                                                    <td>{{ $prov->nome_municipio }}</td>
                                                    <td>{{ $prov->nome_provincia }}</td>
                                                    <td class="text-center" title="Editar">
                                                        <a class="btn btn-primary"
                                                            href="/municipo/editar/{{ $prov->id_municipio }}"><i
                                                                class="bi bi-pen-fill"></i>
                                                    </td></a>
                                                    <td class="text-center" title="Deletar">
                                                        <form action="/municipo/deletar/{{ $prov->id_municipio  }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger"><i
                                                                    class="bi bi-trash"></i></button>
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
                                        {!! $provincias_pais->appends([
        'pesquisar' => request()->get('pesquisar', ''),
    ])->links() !!}
                                    </ul>
                                </nav>

                            </div>
                            {{-- tabela - --}}

                            <div>


                            </div>

                        </div>


                    </div>
                </div>
            </section>

        </main><!-- End #main -->

    </div>




    <script>
        /*
                 let = document.querySelector('#modalChecklistCategoria');
                 let minhaModal = new bootstrap.Modal(e);
                 minhaModal.show();
            */
    </script>

@endsection
