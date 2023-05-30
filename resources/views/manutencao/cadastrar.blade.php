@extends('layouts.main')

@section('title','Manutenção Preventiva')

@section('content')

    <div class="container my-5" style="border:0px solid #000000">

        <main id="main" class="main">

            @error('imagens.*')
                <div class="alert alert-danger fs-5 text-center col-6 mx-auto">
                    {{ $message }}
                </div>
            @enderror

            <div class="pagetitle d-none">
                <nav aria-label="breadcrum  ">
                    <ol class="breadcrumb bg-dark p-2 m-auto col-6 ">
                        <li class="breadcrumb-item "><a href="/portaria/listar">Listar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <h1 class="text-center my-2">Manutenção Preventiva
                  {{-- icone da Manutenção  --}}
                  <svg xmlns="http://www.w3.org/2000/svg" width="32" height="30" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                    <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3c0-.269-.035-.53-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814L1 0Zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708ZM3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026L3 11Z"/>
                  </svg>
                   {{-- icone do carro  --}}
               <svg xmlns="http://www.w3.org/2000/svg" width="32" height="30" fill="currentColor" class="bi bi-bus-front" viewBox="0 0 16 16">
                <path d="M5 11a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm8 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0Zm-6-1a1 1 0 1 0 0 2h2a1 1 0 1 0 0-2H7Zm1-6c-1.876 0-3.426.109-4.552.226A.5.5 0 0 0 3 4.723v3.554a.5.5 0 0 0 .448.497C4.574 8.891 6.124 9 8 9c1.876 0 3.426-.109 4.552-.226A.5.5 0 0 0 13 8.277V4.723a.5.5 0 0 0-.448-.497A44.303 44.303 0 0 0 8 4Zm0-1c-1.837 0-3.353.107-4.448.22a.5.5 0 1 1-.104-.994A44.304 44.304 0 0 1 8 2c1.876 0 3.426.109 4.552.226a.5.5 0 1 1-.104.994A43.306 43.306 0 0 0 8 3Z"/>
                <path d="M15 8a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1V2.64c0-1.188-.845-2.232-2.064-2.372A43.61 43.61 0 0 0 8 0C5.9 0 4.208.136 3.064.268 1.845.408 1 1.452 1 2.64V4a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1v3.5c0 .818.393 1.544 1 2v2a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5V14h6v1.5a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-2c.607-.456 1-1.182 1-2V8ZM8 1c2.056 0 3.71.134 4.822.261.676.078 1.178.66 1.178 1.379v8.86a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 11.5V2.64c0-.72.502-1.301 1.178-1.379A42.611 42.611 0 0 1 8 1Z"/>
              </svg>
               {{-- icone do tempo  --}}
               <svg xmlns="http://www.w3.org/2000/svg" width="32" height="30" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
              </svg>
            </h1>

            @error('item_check')
                <div class="alert alert-danger fs-5 text-center col-6 mx-auto">
                    {{ $message }}
                </div>
            @enderror

            <div id="error-messages" class="alert alert-danger col-6 mx-auto" style="display:none;"></div>

            <section class="section">
                <div class="row">
                    <div class="col-md-8 col-lg-8 mx-auto">
                        <div class="card" style="border:3px solid #000000">
                            <div class="card-body">
                                <h5 class="card-title">Preencha os campos abaixo para registrar a Ordem de serviço </h5>
                                <!-- General Form Elements -->
                                <form id="FormularioManutencaoPreventiva">

                                    <div class="row mb-3">
                                        <!-- Tipo -->
                                        <div class="col-sm-6 col-md-6">
                                            <label for="inputState" class="form-label">
                                                <div class="fs-5">
                                                    <i class="bi bi-list-stars text-danger"></i>
                                                    Tipo de Manutenção
                                                </div>
                                            </label>
                                            <select id="select_tipo_os" name="tipo_manutencao"
                                                class="form-select  @error('tipo') is-invalid @enderror">
                                                <option value="">...</option>
                                                <option value="Mecânica" @if (old('select_tipo_os') == 'Mecânica') selected @endif>
                                                    Mecânica</option>
                                                <option value="Eletrica" @if (old('select_tipo_os') == 'Eletrica') selected @endif>
                                                    Eletrica</option>
                                            </select>
                                            @error('tipo')
                                                <div class="invalid-feedback fs-5">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- veiculos -->
                                        <div class="col-sm-6 col-md-6">
                                            <label for="inputState" class="form-label">
                                                <div class="fs-5">
                                                    <i class="bi bi-truck text-primary"></i> Veiculos
                                                </div>
                                            </label>
                                            <select id="select_veiculos" name="veiculo"
                                                class="form-select
                                            @error('veiculo') is-invalid @enderror">
                                                <option value="">....</option>
                                                @foreach ($veiculos as $veiculo)
                                                    <option value=' {{ $veiculo->id_veiculo }}'
                                                        @if (old('veiculo') == $veiculo->id_veiculo) selected @endif>
                                                        {{ $veiculo->prefixo }}

                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('veiculo')
                                                <div class="invalid-feedback fs-5">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>

                                    {{-- 
                                    <div class="row mb-3">
                                        <!-- Tipo -->
                                        <div class="col-sm-6 col-md-6">
                                            <label for="inputState" class="form-label">
                                                <div class="fs-5">
                                                    <i class="bi bi-list-stars text-primary"></i>
                                                    Situação da OS
                                                </div>
                                            </label>
                                            <select id="situacao_os" name="situacao_os"
                                                class="form-select  @error('situacao_os') is-invalid @enderror">
                                                <option value="">...</option>
                                                <option value="Em_analise"
                                                    @if (old('situacao_os') == 'Em_analise') selected @endif>
                                                    Em Analise</option>
                                                <option value="manutencao_gerada"
                                                    @if (old('situacao_os') == 'manutencao_gerada') selected @endif>
                                                    Manutenção Gerada</option>
                                            </select>
                                            @error('situacao_os')
                                                <div class="invalid-feedback fs-5">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        --}}

                                        <div class="col-sm-6 col-md-6">
                                            <label for="inputState" class="form-label">
                                                <div class="fs-5">
                                                    <i class="bi bi-list-stars text-primary"></i>
                                                    Previsão para  da Manuteção
                                                </div>
                                            </label>
                                            <input type="date" class="form-control" id="previsao_da_manutencao" 
                                             name="previsao_da_manutencao">
                                            @error('data_manutencao')
                                                <div class="invalid-feedback fs-5">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- veiculos -->

                                    </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-lg-8 mx-auto text-center">
                    <div class="row mt-5">
                        <input type="file" multiple="multiple" id="imagens" name="imagens[]"
                            class="btn btn-primary @error('imagens') is-invalid @enderror">
                    </div>
                    @error('imagens')
                        <div class="invalid-feedback fs-5">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="col-md-8 col-lg-8 my-5 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-striped table-bordered datatable">
                                <thead>
                                    <tr>
                                        <th>Serviço</th>
                                        <th>Descrição</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Serviço</th>
                                        <th>Descrição</th>
                                    </tr>
                                </tfoot>
                                <tbody id="corpo_tabela">
                                
                                </tbody>
                            </table>
                            
                            <div id="botoes" class="d-none">
                                <nav>
                                    <ul class="pagination">
                                        <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
                                    </ul>
                                </nav>

                            </div>

                            <button class="btn btn-sm btn-primary float-end" onclick="mostrar_incluir_servico()"
                                title="incluir serviços" type="button">Adcionar serviço</button>
                        </div>

                    </div>

                    <div class="col-md-12 col-lg-12 my-5 mx-auto">

                        @error('item-check')
                            <div class="alert alert-danger fs-5 text-center">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title text-center"><i class="bi bi-ui-checks-grid text-warning"></i>
                                    Ckecklist
                                </h3>
                                <!-- Accordion without outline borders -->
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                aria-expanded="false" aria-controls="flush-collapseOne">
                                                Registrar Anormalias / Problemas
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="card" style="border:3px solid #000000">

                                                    <div class="cad-header">
                                                        <h5 class="card-title text-center mb-2 bg-danger text-white p-2">
                                                            <i class="bi bi-ui-checks-grid"></i>&nbsp;&nbsp;Assinale onde
                                                            estiver com problemas
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Advanced Form Elements -->
                                                        <div class="row mb-5">
                                                            <div class="col-sm-10">

                                                                @foreach ($checklists as $checklist)
                                                                    <div class="row mb-3">
                                                                        <div class="col-sm-10">
                                                                            <div class="form-check">
                                                                                <input id="{{ $checklist->id_checklist }}"
                                                                                    class="form-check-input larger"
                                                                                    type="checkbox" name="item_check[]"
                                                                                    value="{{ $checklist->id_checklist }}"
                                                                                    @if (is_array(old('item_check')) && in_array($checklist->id_checklist, old('item_check'))) checked @endif>
                                                                                <label class="form-check-label"
                                                                                    for="">
                                                                                    {{ $checklist->nome_item }}
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                                <div class="row mb-3">
                                                                    <label class="form-check-label" for="gridCheck3">
                                                                        Breve considreçoes da anormalias
                                                                    </label>
                                                                    <div class="col-sm-12">
                                                                        <div class="form-floating">
                                                                            <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height:100px;" name="descricao">{{ old('descricao') }}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div><!-- End Accordion without outline borders -->

                                <div class="col-md-1 mt-1">
                                    <button class="btn btn-outline-warning btn-sm" type="button"
                                        title="Adcionar Checklist">
                                        <i class="bi bi-plus-square"></i>
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="text-center">
                        <button type="button" class="btn btn-primary" onclick="mostrar_cadastrar()">Cadastrar</button>
                    </div>

                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">salvar dados</h5>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Deseja Realmente Salvar os dados
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary"
                                        id="SalvarManutencaoPreventiva">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-----------fim modal salvar  ------------>

                    </form>

            </section>

        </main><!-- End #main -->

    </div>
    <!----------- modal incluir serviço  ------------>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Serviço</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span id="AlertaMensagem"></span>
                    <form id="form_servico">
                        <div class="mb-3">
                            <label for="nome_servico" class="col-form-label">Serviço</label>
                            <input type="text" class="form-control" id="nome_servico" name="nome_servico">
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="col-form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Sair</button>
                            <button type="submit" class="btn btn-primary"> Adicionar</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
 {{-- --}}
    <!----------- fim modal incluir serviço  ------------>

    <!----------- modal serviço actualizar  ------------>
    <div class="modal fade" id="formulario-actualizar"
     tabindex="-1" aria-labelledby="formulario-actualizarLabel" aria-hidden="true"
     data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Actualizar Serviço</h5>
                </div>
                <div class="modal-body">
                    <span id="AlertaMensagem"></span>
                    <form id="form_editar">
                        <div class="mb-3">
                            <label for="nome_servico" class="col-form-label">Serviço</label>
                            <input type="text" class="form-control" id="nome" name="nome_servico">
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="col-form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="fechar">Sair</button>
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!----------- fim modal incluir serviço  ------------>

@endsection
