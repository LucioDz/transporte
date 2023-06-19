@extends('layouts.main')

@section('title', 'Imagens Portaria')

@section('content')
    <div class="container mb-5">

        <!--  container galeria -->
        <!-- De modo a criar uma galeria com ligth box mas reponsiva ulitizou o pluguin magnific-popup -->

        <div class="row">

            <h1 class='text-center'>Imagens Registradas na ordem de serviço do veiculo
                {{ $ordemServico[0]->prefixo }}
                <hr class="font-weight-bolder display-5" style="background-color:#000000">

                <div class="galleria-001">

                    @if (count($imagens) > 0)

                        @foreach ($imagens as $OS)
                            <div class="Moldura mb-5">
                                <a class="image-link" href="{{ asset('storage/' . $OS->caminho_imagem) }}">
                                    <img src="{{ asset('storage/' . $OS->caminho_imagem) }}"></a>

                                <div class="m-auto btn btn-sm btn-warning"
                                    onclick="location.href ='baixar/{{ $OS->id_imagem_os }}'">Baixar</div>

                                @can('updateOrdemServico', $dados_ordemServico)
                                    <div class="m-auto btn btn-sm btn-primary"
                                        onclick="location.href ='editar/{{ $OS->id_imagem_os }}'">editar</div>

                                    <div class="m-auto btn btn-sm btn-danger"
                                        onclick="location.href ='deletar/{{ $OS->id_imagem_os }}'">deletar</div>
                                @endcan

                            </div>
                        @endforeach
                    @else
                </div>
                <div class="alert alert-danger fs-4 text-center col-8 mx-auto">Sem
                    registro de Imagens
                </div>
                @endif
        </div>

        @can('updateOrdemServico', $dados_ordemServico)
            <div class="row text-center mt-5">
                <h5 class="text-center">Adicionar Imagens</h5>

                <div class="col-md-8 col-lg-8 mx-auto text-center">
                    <form method="POST" action="adicionar/{{ $id_os }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="file" multiple="multiple" name="imagens[]"
                                class="btn btn-primary @error('imagens') is-invalid @enderror">
                            @error('imagens')
                                <div class="invalid-feedback fs-5">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <button type="button" class="btn btn-primary" onclick="mostrar_cadastrar()">Adcionar</button>
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
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        @endcan

    @endsection
