@extends('layouts.main')

@section('title', 'Imagens Portaria')

@section('content')

    <div class="container mb-5">

        <!--  container galeria -->
        <!-- De modo a criar uma galeria com ligth box mas reponsiva ulitizou o pluguin magnific-popup -->

        <div class="row">

            <h3 class='text-center'>Imagens Registradas na Manutenção {{ $dados_manutencao[0]->tipo_manutencao }} do veiculo
                {{ $dados_manutencao[0]->prefixo }}</h3>
                <hr class="font-weight-bolder" style="background-color:#000000">

                <div class="galleria-001">

                    @if (count($imagens) > 0)

                        @foreach ($imagens as $img)
                            <div class="Moldura mb-5">
                                <a class="image-link" href="{{ asset('storage/'.$img->caminho_imagem) }}">
                                    <img src="{{ asset('storage/'.$img->caminho_imagem) }}"></a>

                                <div class="m-auto btn btn-sm btn-warning"
                                    onclick="location.href ='baixar/{{ $img->id_imagem_preventiva }}'">Baixar</div>

                                @can('update',$manutencao_preventiva)
                                    <div class="m-auto btn btn-sm btn-primary"
                                        onclick="location.href ='/manutencao/preventiva/imagens/editar/{{ $img->id_imagem_preventiva }}'">editar</div>

                                    <div class="m-auto btn btn-sm btn-danger"
                                        onclick="location.href ='/manutencao/preventiva/imagens/deletar/{{ $img->id_imagem_preventiva }}'">deletar</div>
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

        @can('update',$manutencao_preventiva)
            <div class="row text-center mt-2">
                <h5 class="text-center">Adicionar Imagens</h5>

                <div class="col-md-8 col-lg-8 mx-auto text-center">
                    <form method="POST" action="/manutencao/preventiva/imagens/adicionar/{{$id_preventiva}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mt-2">
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
