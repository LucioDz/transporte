@extends('layouts.main')

@section('title', 'Editar Imagens Portaria')

@section('content')

    <div class="container  mb-5">
        <!--  container galeria -->
        <!-- De modo a criar uma galeria com ligth box mas reponsiva ulitizou o pluguin magnific-popup -->
        <div class="row my-5">
            <h1 class="text-center">Editar Imagem Registrada na Manutenção {{$manutencao_preventiva[0]->tipo_manutencao }} Veiculo
                {{ $manutencao_preventiva[0]->prefixo }}   </h1>
            <hr class="font-weight-bolder display-5" style="background-color:#000000">

            <div class="galleria-001">
                @if ($imagem != null)
                    <div class="Moldura mb-3">
                      {{-- s3 
                       <a class="image-link" href="{{Storage::disk('s3')->url($imagem->caminho_imagem) }}">
                      <img src="{{ Storage::disk('s3')->url($imagem->caminho_imagem) }}"></a>
                       --}}
                        <a class="image-link" href="{{ asset('storage/'.$imagem->caminho_imagem) }}">
                        <img src="{{ asset('storage/'.$imagem->caminho_imagem) }}"></a>
                    </div>
            </div>
        @else
        </div>
        <div class="alert alert-danger fs-4 text-center col-8 mx-auto">Sem registro de Imgens</div>
        @endif

    <div class="row text-center">

        <div class="col-md-8 col-lg-8 mx-auto text-center">
            <form method="POST" action="/manutencao/preventiva/imagens/actualizar/{{$imagem->id_imagem_preventiva}}" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <input type="file" name="imagem" class="btn btn-primary @error('imagem') is-invalid @enderror">
                    @error('imagem')
                        <div class="invalid-feedback fs-5">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mt-2">
                    <button type="button" class="btn btn-primary" onclick="mostrar_cadastrar()">Actualizar</button>
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
        </div>
    </div>

@endsection
