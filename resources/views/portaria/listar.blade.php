@extends('layouts.main')

@section('title', 'Listar Entrada e saida de veiculos')

@section('content')

    <div class="container my-5">

        <h2 class="text-center my-5 ">
            <i class="text-danger bi bi-list-columns"></i>
            lista de Entrada / Saidas de Veiculos
        </h2>

        <div class="col-md-4 col-sm-6 mx-auto mb-3">

            <form class="d-flex" action="/portaria/pesquisar" method="POST">
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
                <button class="btn btn-outline-danger" type="submit">Pesquisar</button>
            </form>

        </div>

        <div class="card-body table-responsive">
            @if (isset($pesquisar))
                <div class="pagetitle">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/portaria/listar/base">Listar</a></li>
                            <li class="breadcrumb-item"><a href="/cadastrar/portaria">Cadastar</a></li>
                            <li class="breadcrumb-item active">Portaria</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->

                @else
                  <div class="pagetitle">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/cadastrar/portaria">Cadastar</a></li>
                            <li class="breadcrumb-item active">Portaria</li>
                        </ol>
                    </nav>
                </div><!-- End Page Title -->
            @endif
            <table class="table table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>veiculo</th>
                        <th>Matricula</th>
                        <th>Motorista</th>
                        <th>Cobrador</th>
                        <th>supervisor</th>
                        <th>Kilometragem</th>
                        <th>situação</th>
                        <th>Base</th>
                        <th>Data</th>
                        <th>Imagens</th>
                        <th>editar</th>
                        <th>ver</th>
                        <th>Relatorio</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Tipo</th>
                        <th>veiculo</th>
                        <th>Matricula</th>
                        <th>Motorista</th>
                        <th>Cobrador</th>
                        <th>supervisor</th>
                        <th>Kilometragem</th>
                        <th>situação</th>
                        <th>Base</th>
                        <th>Data</th>
                        <th>Imagens</th>
                        <th>editar</th>
                        <th>ver</th>
                        <th>Relatorio</th>
                    </tr>
                </tfoot>
                <tbody>

                    @if (count($portaria) > 0)

                        @foreach ($portaria as $porta)
                            <tr>
                                <td>
                                    @if ($porta->portaria_tipo == 'Entrada')
                                        <span class="text-success fs-5"><i class="bi bi-arrow-left-circle-fill"></i> </span>
                                    @else
                                        <span class="text-danger fs-5"><i class="bi bi-arrow-right-circle-fill"></i></span>
                                    @endif
                                    {{ $porta->portaria_tipo }}
                                </td>
                                <td>
                                    <a href="/veiculo/perfil/{{$porta->id_veiculo }}"  class="text-dark">
                                    <span class="text-primary fs-5">
                                        <i class="bi bi-truck"></i></span>
                                    {{ $porta->prefixo }}
                                    </a>
                                </td>
                                <td>
                                    <span class="text-primary fs-5">
                                        <i class="bi bi-credit-card-2-front"></i>
                                    </span>
                                    {{ $porta->matricula }}
                                </td>
                                <td>
                                    <a href="/funcionario/perfil/{{$porta->id_motorista }}"
                                        class="text-dark">
                                        <span class="text-success fs-5">
                                            <i class="bi bi-file-earmark-person"></i></span>
                                        {{ $porta->motorista_nome }}
                                        {{ $porta->motorista_sobrenome }}
                                    </a>
                                </td>
                                <td>
                                    <a href="/funcionario/perfil/{{ $porta->id_cobrador }}"
                                        class="text-dark">
                                        <span class="text-dark fs-5">
                                            <i class="bi bi-file-earmark-person"></i>
                                        </span>{{ $porta->cobrador_nome }}
                                        {{ $porta->cobrador_sobrenome }}
                                    </a>
                                </td>
                                <td>
                                    <a href="/funcionario/perfil/{{ $porta->id_supervisor }}"
                                        class="text-dark">
                                        <span class="text-primary fs-5">
                                            <i class="bi bi-person-workspace"></i>
                                        </span>{{ $porta->supervisor_nome }}
                                        {{ $porta->supervisor_sobrenome }}
                                    </a>
                                </td>
                                <td>
                                    <span class="text-success fs-5">
                                        <i class="bi bi-speedometer"></i></span>
                                    {{ $porta->portaria_kilometragem }}
                                </td>

                                <td>
                                    <span class="text-info fs-5">
                                        <i class="bi bi-layers-half"></i></span>
                                    {{ $porta->situcao_veiculo }}
                                </td>

                                 <td>
                                    <span class="text-success fs-5">
                                        <i class="bi bi-pin-map-fill"></i></span>
                                    {{ $porta->nome_base}}
                                  </td>

                                <td class="text-center">
                                    <span class="text-warning fs-5">
                                        <i class="bi bi-calendar2-week-fill"></i></span>
                                        {{date('d/m/Y',strtotime($porta->dataHora))}}
                                        
                                        {{ date("H:m:s",strtotime($porta->dataHora)) }}
                                  </td>

                                <td class="text-center" title="Editar">
                                    <a class="btn btn-danger" href="/portaria/imagens/{{ $porta->id_portaria }}"><i
                                            class="bi bi-card-image"></i>
                                <td class="text-center" title="Editar">
                                    <a class="btn btn-primary" href="/portaria/editar/{{ $porta->id_portaria }}">
                                        <i class="bi bi-pen-fill"></i>
                                </td></a>

                                </td></a>
                                <td title=""><a class="btn btn-warning fs-5"
                                        href="/portaria/checklist/{{ $porta->id_portaria }}">
                                        <i class="bi bi-ui-checks-grid"></i></td></a>

                                <td class="text-center" title="imprimir"><a class="btn btn-info fs-5"
                                        href="/portaria/imprimir/{{ $porta->id_portaria }}" target="blanck"><i
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
                    {!! $portaria->appends([
                            'pesquisar' => request()->get('pesquisar', ''),
                        ])->links() !!}
                </ul>
            </nav>

        </div>

    </div>


@endsection
