@extends('layouts.main')

@section('title', 'Base cadastrar')

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


    <div class="container p-5">


        <section class="section profile">

            <div class="row">

                <div class="pagetitle">
                    <h1> <i class="bi bi-pin-map-fill text-info"></i> Base</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/funcionario/listar">Bases</a></li>
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
                                    <form action="/base/cadastrar" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-3">
                                            <label for="profileImage"
                                                class="col-md-4 col-lg-3 col-form-label">Imagem</label>
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
                                                <input name="nome_base" type="text" id="nome_base"
                                                    value="{{ old('nome_base') }}"
                                                    class="form-control @error('nome_base') is-invalid @enderror">
                                                @error('nome_base')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Localidade</label>
                                            <div class="col-md-8 col-lg-9">
                                                <select id="id_municipio" name="id_municipio" class="form-select @error('id_municipio') is-invalid @enderror">
                                                   <option>............</option>
                                                    <optgroup label="Províncias">
                                                        @foreach ($muncipios_provincias as $item)
                                                            @if ($loop->first || $item->provincia_id !== $muncipios_provincias[$loop->index - 1]->provincia_id)
                                                                <option value="" disabled>{{ $item->nome_provincia }}</option>
                                                            @endif
                                                            <option value="{{ $item->id_municipio }}" @if (old('id_municipio') == $item->id_municipio) selected @endif>
                                                                {{ $item->nome_municipio }}
                                                            </option>
                                                        @endforeach
                                                    </optgroup>
                                                </select>
                                                @error('id_municipio')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="row mb-3">
                                            <label for="about" class="col-md-4 col-lg-3 col-form-label">Descricão</label>
                                            <div class="col-md-8 col-lg-9">
                                                <textarea name="descricao" class="form-control" id="about" style="height: 100px">{{ old('descricao') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="text-center">
                                            <span onclick="mostrar_cadastrar()" data-toggle="modal"
                                                data-target="#exampleModalCenter" class="btn btn-info">Cadastrar</span>
                                        </div>
                                        <!-- End Profile Edit Form -->
                                </div>
                            </div><!-- End Bordered Tabs -->


                        </div>
                    </div>

                </div>

            </div>

        </section>


        <!-- Modal -->


    </div><!-- End #container -->


    </div>
    </section>

    </main><!-- End #main -->

    </div>


    {{-- Modal enviar dados --}}

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
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
    {{-- fim Modal enviar dados --}}
    </form>



    <script>
        /*
                         let = document.querySelector('#modalChecklistCategoria');
                         let minhaModal = new bootstrap.Modal(e);
                         minhaModal.show();
                    */
    </script>

@endsection
