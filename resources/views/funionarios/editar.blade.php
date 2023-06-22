@extends('layouts.main')

@section('title', 'Editar Funcionario')

@section('content')

    <div class="container p-5">

<section class="section profile">
       
    <div class="row">
   
        <div class="pagetitle">
            <h1>Editar Funcionario</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/funcionario/listar">Funcionarios</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </nav>
        </div> <!-- End Page Title -->

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
                                    <form action="/funcionario/actualizar/{{ $funcionario->id_funcionario }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Foto de
                                                Perfil</label>
                                            <div class="col-md-8 col-lg-9">
                                                @if ( $funcionario->imagem != null)
                                           
                                                <img src=" {{ asset('storage/' . $funcionario->imagem) }}" height="150px"
                                                        alt="Profile" id="photo_ferfil">

                                                      {{-- 
                                                    <img src="{{Storage::disk('s3')->url($funcionario->imagem) }}" height="150px"
                                                        alt="Profile" id="photo_ferfil">
                                                        --}}
                                                @else
                                                    <img src="/img/perfilsemfoto.jpg" height="150px" alt="Profile"
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
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nome</label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="nome" type="text" id="nome"
                                                    value="{{ old('nome', $funcionario->Nome) }}"
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
                                                    value="{{ old('sobrenome', $funcionario->Sobrenome) }}"
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
                                                    value="{{ old('numero_mecanografico', $funcionario->numero_mecanografico) }}"
                                                    class="form-control @error('numero_mecanografico') is-invalid @enderror">
                                                @error('numero_mecanografico')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                               {{-- -  
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Função 1 </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="funcao1" type="text" id="sobrenome"
                                                    value="{{ old('funcao1', $funcionario->class_funcao1) }}"
                                                    class="form-control @error('funcao1') is-invalid @enderror">
                                                @error('funcao1')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Função 2 </label>
                                            <div class="col-md-8 col-lg-9">
                                                <input name="funcao2" type="text" id="sobrenome"
                                                    value="{{ old('funcao2', $funcionario->class_funcao1) }}"
                                                    class="form-control @error('funcao2') is-invalid @enderror">
                                                @error('funcao2')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- -  
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Genero</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select aria-label="Default select example" name="genero"
                                                    class="form-control @error('genero') is-invalid @enderror">
                                                    <option value="">....</option>
                                                    <option value="masculino"
                                                        @if (old('genero') == 'masculino') selected @endif>Masculino</option>
                                                    <option value="femenino"
                                                        @if (old('genero') == 'femenino') selected @endif>Femenino</option>
                                                </select>
                                                @error('genero')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                           
                                        </div> --}}
                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Base</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select aria-label="Default select example" name="base"
                                                    class="form-control @error('base') is-invalid @enderror">
                                                    @foreach ($bases as $base)
                                                        <option value="{{ $base->id_base }}"
                                                            @if (old('base',$base->id_base) == $funcionario->id_base) selected 
                                                            @elseif (old('base') == $base->id_base) selected @endif>
                                                            {{ $base->nome_base }}</option>
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
                                            <label for="about"
                                                class="col-md-4 col-lg-3 col-form-label">Descricão</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="descricao" class="form-control" id="about" style="height:100px">{{ $funcionario->descricao }}</textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <button type="button" class="btn btn-primary"
                                                onclick="mostrar_actulizar()">Salvar</button>
                                        </div>
                                        <!-- End Profile Edit Form -->
                                </div>

                                <div class="tab-pane fade pt-3" id="profile-change-password">
                                    <!-- Change Password Form -->

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
                                Selecione o Tipo de Fuinarionario
                            </h4>
                            <hr>
                            <div class="row mb-3  @error('funcionario_tipo') is-invalid @enderror">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label text-center"> Tipo de
                                    funionario</label>
                                <div class="col-md-8 col-lg-9">
                                    <div class="form-check  pb-2">
                                        <input class="form-check-input" type="checkbox" id="changesMade"
                                            name="funcionario_tipo[]" value="motorista"
                                            @if ($funcionario->funcionario_tipo == 'motorista') checked @endif>
                                        <label class="form-check-label" for="changesMade">
                                            Motorista
                                        </label>
                                    </div>
                                    <div class="form-check pb-2">
                                        <input class="form-check-input" type="checkbox" id="newProducts"
                                            name="funcionario_tipo[]" value="cobrador"
                                            @if ($funcionario->funcionario_tipo == 'cobrador') checked @endif>
                                        <label class="form-check-label" for="newProducts">
                                            Cobrador
                                        </label>
                                    </div>
                                    <div class="form-check ">
                                        <input class="form-check-input" type="checkbox" id="securityNotify"
                                            name="funcionario_tipo[]" value="supervisor"
                                            @if ($funcionario->funcionario_tipo == 'supervisor') checked @endif>
                                        <label class="form-check-label" for="securityNotify">
                                            Supervisor
                                        </label>
                                    </div>
                                    <div class="form-check pb-2">
                                        <input class="form-check-input" type="checkbox" id="proOffers"
                                            name="funcionario_tipo[]" value="administrador_base"
                                            @if ($funcionario->funcionario_tipo == 'administrador_base') checked @endif>
                                        <label class="form-check-label" for="proOffers">
                                            Adminstrador da Base
                                        </label>
                                    </div>
                                    <div class="form-check pb-2">
                                        <input class="form-check-input" type="checkbox" id="proOffers"
                                            name="funcionario_tipo[]" value="administrador_senior"
                                            @if ($funcionario->funcionario_tipo == 'administrador_senior') checked @endif>
                                        <label class="form-check-label" for="proOffers">
                                            Adminstrador Senior
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @error('funcionario_tipo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <!-- modal -->
                            <div class="modal fade" id="mostrar_actulizar" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">salvar dados
                                            </h5>
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
                            <!-- fim modal -->
                            </form> <!-- fim formulario -->
                        </div>
                    </div>
                    {{-- - Cadastrar usuario --}}
                    @if (in_array($funcionario->funcionario_tipo, $permitidos_login) && $funcionario_usuario == null)

                        <div class="row mt-2">
                            @if (session('usuario') != null)
                                <div class="altert alert-danger p-3 mb-3">
                                    {{ session('usuario') }}
                                </div>
                            @endif
                            <div class="card  p-5">
                                <h4 class="text-center">
                                    <i class="bi bi-signpost-2-fill"></i>
                                    Campos de Usuario
                                </h4>
                                <hr>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    {{-- 
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Nome</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    */
                                    ---}}
                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword"
                                            class="col-md-4 col-lg-3 col-form-label">Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">
                                            Comfirmar Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="password_confirmation" required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="row mb-3 d-none">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">
                                            ComfirmarPassword</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input id="password-confirm" type="password" class="form-control"
                                                name="id_funcionario" required autocomplete="new-password"
                                                value="{{ $funcionario->id_funcionario }}">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Salvar Dados</button>
                                    </div>
                                    <div class="modal fade" id="mostrar_usuario" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">salvar dados
                                                    </h5>
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

                                </form><!-- End Change Password Form -->


                            </div>
                        </div>
                </div>
                @endif

            </div>

    </div>
    </section>

    </div><!-- End #container -->



@endsection
