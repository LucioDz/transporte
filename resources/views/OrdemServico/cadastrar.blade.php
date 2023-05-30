@extends('layouts.main')

@section('title', 'Criar OS')

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

            <h1 class="text-center my-2">Ordem de Serviço
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="30" fill="currentColor"
                    class="bi bi-card-checklist" viewBox="0 0 16 16">
                    <path
                        d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z" />
                    <path
                        d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z" />
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
                                <form id="FormularioOrdemServico">

                                    <div class="row mb-3">
                                        <!-- Tipo -->
                                        <div class="col-sm-6 col-md-6">
                                            <label for="inputState" class="form-label">
                                                <div class="fs-5">
                                                    <i class="bi bi-list-stars text-danger"></i>
                                                    Tipo a OS
                                                </div>
                                            </label>
                                            <select id="select_tipo_os" name="tipo_os"
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
                                        id="salvarOrdemServico">Salvar</button>
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
