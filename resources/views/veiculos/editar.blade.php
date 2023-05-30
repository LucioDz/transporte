@extends('layouts.main')

@section('title', 'Veiculos cadastrar')

@section('content')

    <div class="container p-5">

        <section class="section profile">
           
            <div class="row">
                
        <div class="pagetitle">
            <div class="fs-5 text-primary">
                <i class="bi bi-truck"></i>
            </div>
            <h1>
                <i class="bi bi-truck"></i>
               Editar Veiculo</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/veiculos/listar">Veiculos</a></li>
                    <li class="breadcrumb-item active">Cadastrar</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

                <div class="col-xl-7 mb-2">
                    <div class="card">

                        <div class="card-body pt-3">

                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-edit">
                                        Perfil</button>
                                </li>

                            </ul>

                            <div class="tab-content pt-2">

                                <div class="tab-pane fade show active profile-edit pt-3" id="profile-edit">

                                    <!-- Profile Edit Form -->
                                    <form action="/veiculo/actualizar/{{$veiculo->id_veiculo}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto de
                                                Perfil</label>
                                                <div class="col-md-8 col-lg-9">
                                                    @if ($veiculo->imagem != null)
                                                        <img src="{{Storage::disk('s3')->url($veiculo->imagem) }}"
                                                            height="150px" alt="Profile" id="photo_ferfil">
                                                    @else
                                                    <img src="/img/veiculo.png" height="150px" alt="Profile"
                                                            id="photo_ferfil">
                                                    @endif
                                                    <div class="pt-2">
                                                        <label for="foto_de_perfil" class="btn btn-primary btn-sm"
                                                            title="Carregar nava nova foto de perfil">
                                                            <i class="bi bi-upload"></i>
                                                        </label>
                                                        <label class="btn btn-danger btn-sm" title="Remover imagem "><i
                                                                class="bi bi-trash" onclick="RemoverImagemPrevisualizada()">
                                                            </i></a>
                                                        </label>
                                                    </div>
                                                </div>
                                           
                                        </div>

                                        <div class="row mb-3 d-none">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Foto de
                                                Perfil</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="foto_de_perfil" type="file" id="foto_de_perfil"
                                                    class="form-control @error('foto_de_perfil') is-invalid @enderror"
                                                    onchange="previsualizarImagem()">
                                                @error('foto_de_perfil')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Marca</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="marca" type="text" id="marca" value="{{ old('marca',$veiculo->marca) }}"
                                                    class="form-control @error('marca') is-invalid @enderror">
                                                @error('marca')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Prefixo</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="prefixo" type="text" id="prefixo"
                                                    value="{{ old('prefixo',$veiculo->prefixo) }}"
                                                    class="form-control @error('prefixo') is-invalid @enderror">
                                                @error('prefixo')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Matricula
                                                </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="matricula" type="text" id="matricula"
                                                    value="{{ old('matricula',$veiculo->matricula) }}"
                                                    class="form-control @error('matricula') is-invalid @enderror">
                                                @error('matricula')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Modelo</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="modelo" type="text" id="modelo"
                                                    value="{{old('modelo',$veiculo->modelo)}}"
                                                    class="form-control @error('modelo') is-invalid @enderror">
                                                @error('modelo')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Motor</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="motor" type="text" id="motor"
                                                    value="{{old('motor',$veiculo->motor)}}"
                                                    class="form-control @error('motor') is-invalid @enderror">
                                                @error('motor')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                         <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Chassis</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="chassis" type="text" id="chassis"
                                                    value="{{ old('chassis',$veiculo->chassis) }}"
                                                    class="form-control @error('chassis') is-invalid @enderror">
                                                @error('chassis')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Lugares Sentados</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="lugares_sentados" type="number" id="lugares_sentados"
                                                    min="0" value="{{ old('lugares_sentados',$veiculo->lugares_sentados) }}"
                                                    class="form-control @error('lugares_sentados') is-invalid @enderror"
                                                    >
                                                @error('lugares_sentados')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">
                                                Em Pe</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="em_pe" type="number" min="0" id="em_pe"
                                                    value="{{old('em_pe',$veiculo->lugares_em_pe) }}"
                                                    class="form-control @error('em_pe') is-invalid @enderror"
                                                   >
                                                @error('em_pe')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">
                                                Lotação</label>
                                            <div class="col-md-7 col-lg-7">
                                                <input name="lotacao" type="number" min="0" id="lotacao"
                                                    value="{{ old('lotacao',$veiculo->lotacao) }}"
                                                    class="form-control @error('lotacao') is-invalid @enderror" 
                                                  readonly>
                                                @error('lotacao')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-1">
                                                <button class="btn btn-outline-primary btn-sm" type="button"
                                                onclick="calcular_lotacao()" title="Calcular Lotação">
                                                  <i class="bi bi-plus-square"></i>
                                                </button>
                                              </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">
                                                Ano de Fabrico</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="ano_fabrico" type="number" min="1980" id="ano_fabrico"
                                                    value="{{ old('ano_fabrico',$veiculo->ano) }}"
                                                    class="form-control @error('ano_fabrico') is-invalid @enderror">
                                                @error('ano_fabrico')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">
                                                pais</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="pais" type="text"  id="pais"
                                                    value="{{ old('pais',$veiculo->pais) }}"
                                                    class="form-control @error('pais') is-invalid @enderror">
                                                @error('pais')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">
                                                Kilometragem</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="kilometragem" type="text"  id="kilometragem"
                                                    value="{{ old('kilometragem',$veiculo->kilometragem) }}"
                                                    class="form-control @error('kilometragem') is-invalid @enderror">
                                                @error('kilometragem')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                   
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Base</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select aria-label="Default select example" name="base"
                                                    class="form-control @error('base') is-invalid @enderror">
                                                    <option value="">....</option>
                                              
                                                @foreach ($bases as $base )
                                                    <option value="{{$base->id_base}}" 
                                                        @if (old('base',$base->id_base) == $veiculo->id_base ) selected
                                                        @elseif (old('base') == $base->id_base) selected
                                                        @endif>
                                                       {{ $base->nome_base}}</option>
                                                @endforeach
                                                   
                                                </select>
                                                @error('base')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <span onclick="mostrar_cadastrar()" data-toggle="modal"
                                                data-target="#exampleModalCenter" class="btn btn-primary">Actualizar</span>
                                        </div>
                                        <!-- End Profile Edit Form -->
                                </div>
                            </div><!-- End Bordered Tabs -->


                        </div>
                    </div>

                </div>

                <div class="col-xl-5 ">

                    <div class="row">

                        <div class="card p-4">
                            <h4 class="text-center">
                                <i class="bi bi-truck text-danger"></i>
                                  Situação do veiculo
                            </h4>
                            <hr>
                            <div class="row mb-3  @error('situacao') is-invalid @enderror">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label text-center">
                                    Selecione a situação actual do veiculo
                                </label>
                                <div class="col-md-8 col-lg-9">
                                    <div class="form-check  pb-2">
                                        <input class="form-check-input" type="checkbox" id="changesMade"
                                            name="situacao[]" value="Em_uso"
                                            @if ($veiculo->situacao == 'Em uso') checked
                                            @elseif(is_array(old('situacao')) && in_array('Em_uso',old('situacao')) )checked @endif>
                                        <label class="form-check-label" for="changesMade">
                                           Em uso
                                        </label>
                                    </div>
                                    <div class="form-check pb-2">
                                        <input class="form-check-input" type="checkbox" id="newProducts"
                                            name="situacao[]" value="Em Garagem"
                                            @if ($veiculo->situacao == 'Em Garagem') checked 
                                            @elseif(is_array(old('situacao')) && in_array('Em Garagem',old('situacao')) )checked 
                                            @endif>
                                        <label class="form-check-label" for="newProducts" >
                                            Em Garagem
                                        </label>
                                    </div>
                                    <div class="form-check pb-2">
                                        <input class="form-check-input" type="checkbox" id="proOffers"
                                            name="situacao[]" value="Em Manutenção"
                                            @if ($veiculo->situacao == 'Em Manutenção') checked
                                            @elseif(is_array(old('situacao')) && in_array('Em Manutenção',old('situacao')) )checked
                                            @endif>
                                        <label class="form-check-label" for="proOffers">
                                            Em Manutenção
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @error('situacao')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>

                    </div>


                </div>

            </div>

        </section>


        <!-- Modal -->


    </div><!-- End #container -->

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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    </form>


@endsection
