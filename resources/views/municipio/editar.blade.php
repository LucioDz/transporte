@extends('layouts.main')

@section('title', 'Veiculos cadastrar')

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

    <div class="container my-5">

        <main id="main" class="main">

            <div class="pagetitle">
                <h1 class="text-center"> <i class="bi bi-pin-map-fill text-info"></i>Municipio</h1>
            </div><!-- End Page Title -->
            <section class="section">

                <div class="row my-5">

                    <div class="col-lg-6 mx-auto ">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><i class="bi bi-map-fill text-info"></i> Editar os dados
                                    <!-- General Form Elements -->
                                    <form method="POST" action="/municipo/actualizar/{{$municipio->id_municipio}}" name="formulario">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-3">
                                            <label for="inputText" class="col-sm-2 col-form-label">Provincia</label>
                                            <div class="col-sm-8">
                                                <select id="provincia" name="id_provincia"
                                                    class="form-select @error('id_provincia') is-invalid @enderror">
                                                    @foreach ($provincias as $provincia)
                                                        <option value="{{ $provincia->id_provincia }}"
                                                             @if($provincia->id_provincia  == $municipio->id_provincia) selected
                                                            @endif>{{ $provincia->nome_provincia }}</option>
                                                    @endforeach
                                                </select>
                                                @error('id_provincia')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="row mb-3">
                                            <label for="inputText" class="col-sm-2 col-form-label">Municipio</label>
                                            <div class="col-sm-10 ">
                                                <input type="text" name="nome_municipio" value="{{ old('nome_municipio',$municipio->nome_municipio) }}"
                                                    class="form-control @error('nome_municipio') is-invalid @enderror">
                                                @error('nome_municipio')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>

                                        </div>

                                        <div class="row mb-3 text-center">
                                            <div class="col-sm-10">
                                                <button type="button" class="btn btn-info" name="enviar"
                                                    value="enviar" onclick="mostrar_cadastrar()" >Actualizar</button>
                                            </div>
                                        </div>
                           
                            </div>
                        </div>



                        <div></div>

                    </div>

                </div>


    </div>


    </div>
    </div>
    </section>

    </main><!-- End #main -->

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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </div>
</div>

</form>


    <script>
        /*
             let = document.querySelector('#modalChecklistCategoria');
             let minhaModal = new bootstrap.Modal(e);
             minhaModal.show();
        */
    </script>

@endsection
