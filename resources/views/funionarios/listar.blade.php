@extends('layouts.main')

@section('title', 'Listar Funcionario')

@section('content')

    <div class="container my-5">

        <h2 class="text-center my-5 ">
            <i class="text-success bi bi-list-columns"></i>
            lista de Funcionarios Cadastrados
        </h2>

        <div class="col-md-4 col-sm-6 mx-auto mb-3">

            <form class="d-flex" action="{{$rota_de_pesquisa}}" method="POST">
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
                <button class="btn btn-outline-success" type="submit">Pesquisar</button>
            </form>

        </div>


        <div class="card-body table-responsive">
        @if (isset($pesquisar))
            <div class="pagetitle me-2">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/funcionario/listar">Funcionarios</a></li>
                        <li class="breadcrumb-item"><a href="/cadastrar/funcionario">Cadastar</a></li>
                        <li class="breadcrumb-item active">Funcionarios</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
        @else
            <div class="pagetitle me-2">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/cadastrar/funcionario">Cadastar</a></li>
                        <li class="breadcrumb-item active">Funcionarios</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->
        @endif
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Numero_mecanografico</th>
                        <th>Tipo</th>
                        <th>Base</th>
                        <th>Perfil</th>
                        <th>editar</th>
                        <th>Deletar</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Numero_mecanografico</th>
                        <th>Tipo</th>
                        <th>Base</th>
                        <th>editar</th>
                        <th>Perfil</th>
                        <th>Deletar</th>
                    </tr>
                </tfoot>
                <tbody>

                    @if (count($funcionarios) > 0)

                        @foreach ($funcionarios as $funcionario)
                            <tr>
                                <td class="text-capitalize">{{ $funcionario->Nome }}</td>
                                <td class="text-capitalize">{{ $funcionario->Sobrenome }}</td>
                                <td>{{ $funcionario->numero_mecanografico }}</td>
                                <td class="text-capitalize">{{ $funcionario->funcionario_tipo }}</td>
                                <td>{{ $funcionario->nome_base }}</td>
                                <td class="text-center" title="Perfil"><a class="btn btn-success fs-5"
                                    href="/funcionario/perfil/{{ $funcionario->id_funcionario }}"> <i class="bi bi-file-earmark-person"></i></td></a>
                                <td class="text-center" title="Editar">
                                    <a class="btn btn-primary"
                                        href="/funcionario/editar/{{ $funcionario->id_funcionario }}">
                                        <i class="bi bi-pen-fill"></i>
                                        </a>
                                </td>
                                <td class="text-center" title="Deletar">
                                    <form action="/funcionario/deletar/{{ $funcionario->id_funcionario }}" method="POST">
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
                    {!! $funcionarios->appends([
                    'pesquisar' => request()->get('pesquisar', ''),
                  ])->links() !!}
                </ul>
            </nav>

        </div>

    </div>

@endsection
