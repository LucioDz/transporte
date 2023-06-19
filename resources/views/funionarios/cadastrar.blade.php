@extends('layouts.main')

@section('title', 'Cadastrar Funcionario')

@section('content')

    <div class="container p-5">

        <div class="pagetitle">
            <h1>Cadastro de Funcionario</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/funcionario/listar">Funcionarios</a></li>
                    <li class="breadcrumb-item active">Cadastrar</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section profile">
            <div class="row">

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
                                    <form action="/funcionario/cadastrar" method="post" enctype="multipart/form-data"
                                     class="formulario">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto de
                                                Perfil</label>
                                            <div class="col-md-8 col-lg-9">
                                                <img src="/img/perfilsemfoto.jpg" height="150px" alt="Profile"
                                                    id="photo_ferfil" class="@error('foto_de_perfil') is-invalid @enderror">
                                                    @error('foto_de_perfil')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
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
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nome</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nome" type="text" id="nome" value="{{ old('nome') }}"
                                                    class="form-control @error('nome') is-invalid @enderror">
                                                @error('nome')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Sobre
                                                nome</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="sobrenome" type="text" id="sobrenome"
                                                    value="{{ old('sobrenome') }}"
                                                    class="form-control @error('sobrenome') is-invalid @enderror">
                                                @error('sobrenome')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Numero
                                                mencanografico </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="numero_mecanografico" type="text" id="numero_mecanografico"
                                                    value="{{ old('numero_mecanografico') }}"
                                                    class="form-control @error('numero_mecanografico') is-invalid @enderror">
                                                @error('numero_mecanografico')
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
                                                    <option value="{{$base->id_base}}" @if (old('base') == $base->id_base) selected @endif>
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

                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Descricão</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="descricao" class="form-control" id="about" 
                                                style="height: 100px">{{old('descricao') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary"
                                                onclick="mostrar_cadastrar()">Cadastrar</button>
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
                                <i class="bi bi-signpost-2-fill"></i>
                                Selecione o Tipo de Funcionario
                            </h4>
                            <hr>
                            <div class="row mb-3  @error('funcionario_tipo') is-invalid @enderror">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label text-center"> Tipo de
                                    funcionario</label>
                                <div class="col-md-8 col-lg-9">
                                    <div class="form-check  pb-2">
                                        <input class="form-check-input" type="checkbox" id="changesMade"
                                            name="funcionario_tipo[]" value="motorista">
                                        <label class="form-check-label" for="changesMade">
                                            Motorista
                                        </label>
                                    </div>
                                    <div class="form-check pb-2">
                                        <input class="form-check-input" type="checkbox" id="newProducts"
                                            name="funcionario_tipo[]" value="cobrador">
                                        <label class="form-check-label" for="newProducts" >
                                            Cobrador
                                        </label>
                                    </div>
                                    <div class="form-check ">
                                        <input class="form-check-input" type="checkbox" id="securityNotify"
                                            name="funcionario_tipo[]" value="supervisor">
                                        <label class="form-check-label" for="securityNotify">
                                            Supervisor
                                        </label>
                                    </div>
                                    <div class="form-check pb-2">
                                        <input class="form-check-input" type="checkbox" id="proOffers"
                                            name="funcionario_tipo[]" value="administrador_base">
                                        <label class="form-check-label" for="proOffers">
                                            Administrador da Base
                                        </label>
                                    </div>
                                    <div class="form-check pb-2">
                                        <input class="form-check-input" type="checkbox" id="proOffers"
                                            name="funcionario_tipo[]" value="administrador_senior">
                                        <label class="form-check-label" for="proOffers">
                                            Administrador Senior
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @error('funcionario_tipo')
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
                    <button type="submit" class="btn btn-primary botaoformulario">Salvar</button>
                </div>
            </div>
        </div>
    </div>

</form>


@endsection
