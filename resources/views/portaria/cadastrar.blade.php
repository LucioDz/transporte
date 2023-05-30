@extends('layouts.main')

@section('title', 'Cadastrar Portaria')

@section('content')

    <div class="container my-5" style="border:0px solid #000000">

        <main id="main" class="main">

            @error('imagens.*')
                <div class="alert alert-danger fs-5 text-center col-6 mx-auto">
                    {{ $message }}
                </div>
            @enderror

            <div class="pagetitle d-none">
                <nav aria-label="breadcrum ">
                    <ol class="breadcrumb bg-dark p-2 m-auto col-6 ">
                        <li class="breadcrumb-item "><a href="/portaria/listar">Listar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                    </ol>
                </nav>
                <h1 class="text-center my-2">Entrada e saida de Veiculos</h1>
            </div><!-- End Page Title -->
            @error('item_check')
                <div class="alert alert-danger fs-5 text-center col-6 mx-auto">
                    {{ $message }}
                </div>
            @enderror
            <section class="section">
                <div class="row">
                    <div class="col-md-8 col-lg-8 mx-auto">
                        <div class="card" style="border:3px solid #000000">
                            <div class="card-body">
                                <h5 class="card-title">Preencha os campos abaixo para registrar a Entrada/Saida</h5>
                                <!-- General Form Elements -->
                                <form id="formPortaria"method="POST" action="/portaria/cadastrar" enctype="multipart/form-data"
                                class="formulario">
                                    @csrf
                                    <div class="row mb-3">
                                        <!-- Tipo -->
                                        <div class="col-sm-6 col-md-6">
                                            <label for="inputState" class="form-label">
                                                <div class="fs-5 text-danger">
                                                    <i class="bi bi-door-open-fill"></i> Tipo
                                                </div>
                                            </label>
                                            <select id="select_tipo" name="tipo"
                                                class="form-select  @error('tipo') is-invalid @enderror">
                                                <option value="">...</option>
                                                <option value="Entrada" @if (old('tipo') == 'Entrada') selected @endif>
                                                    Entrada</option>
                                                <option value="Saida" @if (old('tipo') == 'Saida') selected @endif>
                                                    Saida</option>
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
                                                <div class="fs-5 ">
                                                    <i class="bi bi-file-earmark-person text-success"></i>
                                                    Motorista
                                                </div>
                                            </label>
                                            <select id="select_motoristas" name="motorista"
                                                class="form-select
                                            @error('motorista') is-invalid @enderror">
                                                <option value="">....</option>
                                                @foreach ($motoristas as $motorista)
                                                    <option value='{{ $motorista->id_funcionario }}'
                                                        @if (old('motorista') == $motorista->id_funcionario) selected @endif>
                                                        {{ $motorista->Nome }} {{ $motorista->Sobrenome }}</option>
                                                @endforeach
                                            </select>
                                            @error('motorista')
                                                <div class="invalid-feedback fs-5">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- veiculos -->
                                        <div class="col-sm-6 col-md-6">
                                            <label for="inputState" class="form-label">
                                                <div class="fs-5 ">
                                                    <i class="bi bi-file-earmark-person text-success"></i>
                                                    Cobrador
                                                </div>
                                            </label>
                                            <select id="select_cobrador" name="cobrador"
                                                class="form-select
                                            @error('cobrador') is-invalid @enderror">
                                                <option value="">....</option>
                                                @foreach ($cobradores as $cobrador)
                                                    <option value='{{ $cobrador->id_funcionario }}'
                                                        @if (old('cobrador') == $cobrador->id_funcionario) selected @endif>
                                                        {{ $cobrador->Nome }} {{ $cobrador->Sobrenome }}</option>
                                                @endforeach

                                            </select>
                                            @error('cobrador')
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
                                                <div class="fs-5 ">
                                                    <i class="bi bi-truck text-danger"></i>Situação do veiculo
                                                </div>
                                            </label>
                                            <select id="select_tipo" name="situacao"
                                                class="form-select
                                            @error('situacao') is-invalid @enderror">
                                                <option value="">...</option>

                                                <option value="Em uso" @if (old('situacao') == 'Em uso') selected @endif>Em
                                                    uso</option>

                                                <option value="Em Manutenção"
                                                    @if (old('situacao') == 'Em Manutenção') selected @endif>Em Manutenção
                                                </option>

                                                <option value="Em Garagem"
                                                    @if (old('situacao') == 'Em Garagem') selected @endif>Em Garagem</option>

                                            </select>
                                            @error('situacao')
                                                <div class="invalid-feedback fs-5">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <!-- veiculos -->
                                        <div class="col-sm-6 col-md-6">
                                            <label for="inputState" class="form-label">
                                                <div class="fs-5 ">
                                                    <i class="bi bi-speedometer text-primary"></i> Kilometragem
                                                </div>
                                            </label>
                                            <input name="kilometragem" type="text" min="0" id="kilometragem"
                                                value="{{ old('kilometragem') }}"
                                                class="form-control @error('kilometragem') is-invalid @enderror">
                                            @error('kilometragem')
                                                <div class="invalid-feedback fs-5">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-lg-8 mx-auto text-center">
                    <div class="row mt-5">
                        <input type="file" multiple="multiple" name="imagens[]"
                            class="btn btn-primary @error('imagens') is-invalid @enderror">
                    </div>
                    @error('imagens')
                        <div class="invalid-feedback fs-5">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- <div class="col-md-8 col-lg-8 my-5 mx-auto">

                    <div class="card" style="border:3px solid #000000">

                        <div class="cad-header">
                            <h5 class="card-title text-center mb-2 bg-danger text-white p-2">
                                <i class="bi bi-ui-checks-grid"></i>&nbsp;&nbsp;Assinale onde estiver com problemas</h5>
                        </div>
                        <div class="card-body">
                            <!-- Advanced Form Elements -->
                            <div class="row mb-5">
                                <div class="col-sm-10">

                                    @foreach ($checklists as $checklist)
                                    <div class="row mb-3">
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input id="" class="form-check-input larger" type="checkbox"
                                                    name="item-check[]">
                                                <label class="form-check-label" for="">
                                                        {{$checklist->nome_item}} 
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
                                                <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;"
                                                    name="descricao"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div> --}}

                <div class="col-md-8 col-lg-8 my-5 mx-auto">

                    @error('item-check')
                        <div class="alert alert-danger fs-5 text-center">
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center"><i class="bi bi-ui-checks-grid text-warning"></i> Ckecklist
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
                                <button type="submit" 
                                class="btn btn-primary botaoformulario" id="salvarPortaria">Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>

                </form>

            </section>

        </main><!-- End #main -->

    </div>

@endsection
