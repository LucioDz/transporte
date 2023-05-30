@extends('layouts.main')

@section('title','Tcul')

@section('content')

    <div class="container my-5">
      
      <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 text-center">
                <div class="card-body"><span class="text-white fs-4 ">
              <i class="bi bi-truck"></i>  Total de Veiculos   {{ count($veiculos) }}
              <?php //$dados['TotalVeiculos'] ?> </span></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/veiculos/listar"> Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4  text-center">
                <div class="card-body"><span class="text-white fs-4">
                    <i class="bi bi-ui-checks-grid"></i> Total de checklist  {{ count($checklist) }}
              <?php // $dados['TotalChecklistVeiculos']?> </span></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/checklist/listar">Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4  text-center">
            <div class="card-body"><span class="text-white fs-4">
              <i class="bi bi-file-earmark-person"></i> Total de Funcionarios {{ count($funcionarios) }}
              <?php //$dados['TotalUsuaios']?></span></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link"  href="/funcionario/listar"> Ver Detalhes</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4 text-center">
            <div class="card-body"><span class="text-white fs-4">
            <i class="bi bi-door-open-fill"></i> Portaria E/S Total {{ count($portaria) }}
            <?php //$dados['TotalPortaria']?></span></span></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/portaria/listar">Ver Detahles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4 text-center">
            <div class="card-body"><span class="text-white fs-4">
                <i class="bi bi-pin-map-fill"></i> Total de Bases {{ count($bases) }}
            <?php //$dados['TotalPortaria']?></span></span></div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="/base/listar">Ver Detahles</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    </div>

      <div class="card-body table-responsive">

        <h2 class="text-center">Registros Recentes de Entradas e saidas de veiculos </h2>
        
        <table class="table table-striped table-bordered datatable">
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
                                    <span class="text-primary fs-5">
                                        <i class="bi bi-truck"></i></span>
                                    {{ $porta->prefixo }}
                                </td>
                                <td>
                                    <span class="text-primary fs-5">
                                        <i class="bi bi-credit-card-2-front"></i>
                                    </span>
                                    {{ $porta->matricula }}
                                </td>
                                <td>
                                    <a href="/funcionario/perfil/{{$porta->id_motorista}}" class="text-dark">
                                        <span class="text-success fs-5">
                                        <i class="bi bi-file-earmark-person"></i></span>
                                        {{$porta->motorista_nome }} 
                                        {{$porta->motorista_sobrenome }}
                                    </a>
                                </td>
                                <td>
                                    <a href="/funcionario/perfil/{{$porta->id_cobrador}}" class="text-dark">
                                        <span class="text-dark fs-5">
                                            <i class="bi bi-file-earmark-person"></i>
                                        </span>{{ $porta->cobrador_nome}}
                                        {{$porta->cobrador_sobrenome }}
                                    </a>
                                </td>
                                <td>
                                    <a href="/funcionario/perfil/{{$porta->id_supervisor }}" class="text-dark">
                                        <span class="text-primary fs-5">
                                            <i class="bi bi-person-workspace"></i>
                                        </span>{{ $porta->supervisor_nome }}
                                        {{$porta->supervisor_sobrenome }}
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
                                            
                                            {{ date("H:m:s",strtotime($portaria[0]->dataHora)) }}
                                </td>

                                <td class="text-center" title="Editar">
                                    <a class="btn btn-danger" href="/portaria/imagens/{{ $porta->id_portaria }}"><i
                                            class="bi bi-card-image"></i>
                                <td class="text-center" title="Editar">
                                    <a class="btn btn-primary" href="/portaria/editar/{{ $porta->id_portaria }}">
                                        <i class="bi bi-pen-fill"></i>
                                </td></a>

                                </td></a>
                                <td title=""><a class="btn btn-warning fs-5" href="/portaria/checklist/{{ $porta->id_portaria}}">
                                        <i class="bi bi-ui-checks-grid"></i></td></a>

                                <td class="text-center" title="imprimir"><a class="btn btn-info fs-5"
                                    href="/portaria/imprimir/{{ $porta->id_portaria}}" target="blanck"><i
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

        
        </div>


  </body>
</html>


@endsection