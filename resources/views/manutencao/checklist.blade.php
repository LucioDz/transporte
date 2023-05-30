@extends('layouts.main')

@section('title', 'Manutenção preventiva checklist')

@section('content')

    <div class="container my-5" style="border:0px solid #000000">

        <main id="main" class="main">

            <div class="pagetitle d-none">
                <nav aria-label="breadcrum ">
                    <ol class="breadcrumb bg-dark p-2 m-auto col-6 ">
                        <li class="breadcrumb-item "><a href="/portaria/listar">Listar</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <section class="section">

                <div class="col-md-8 col-lg-8 my-5 mx-auto">

                    @if (count($manutencao_preventiva) > 0)

                        <h2 class='text-center'>Anormalias/problemas Registrados na
                            Manutenção {{ $manutencao_preventiva[0]->tipo_manutencao }} do
                            veiculo {{ $manutencao_preventiva[0]->prefixo }} </h2>
                        <hr class="font-weight-bolder display-5" style="background-color:#000000">

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
                                                Anormalias / Problemas
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="card" style="border:3px solid #000000">

                                                    <div class="cad-header">
                                                        <h5 class="card-title text-center mb-2 bg-danger text-white p-2">
                                                            <i class="bi bi-ui-checks-grid"></i>&nbsp;&nbsp;
                                                            Anormalias assinaladas

                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <!-- Advanced Form Elements -->
                                                        <div class="row mb-5">
                                                            <div class="col-sm-10">

                                                                @foreach ($manutencao_preventiva_cheklist as $checklist)
                                                                    <div class="row mb-3">
                                                                        <div class="col-sm-10">
                                                                            <div class="form-check">
                                                                                <input id="{{ $checklist->id_checklist }}"
                                                                                    class="form-check-input larger"
                                                                                    type="checkbox" name="item_check[]"
                                                                                    value="{{ $checklist->id_checklist }}"
                                                                                    @if ($checklist->item_selecionado == 1) checked
                                                                                @elseif(is_array(old('item_check')) && in_array($checklist->id_checklist, old('item_check')))checked @endif
                                                                                    disabled>
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
                                                                            <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height:100px;" name="descricao"
                                                                                disabled>{{ old('descricao', $portaria_descricao) }}</textarea>
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
                            </div>
                        </div>
                    @else
                        <div class="alert alert-danger fs-5 text-center">Nenhuma anormalia Registrada</div>

                    @endif

                </div>


                </form>

            </section>

        </main><!-- End #main -->

    </div>

@endsection
