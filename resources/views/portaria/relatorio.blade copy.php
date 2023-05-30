<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>


    
    <style>
        @media dompdf {
            * {
                line-height: 1.2;
            }
        }

        input.larger {
            width: 22px;
            height: 22px;
        }

        .linha {
            border: 4px solid #FF0000;
            border-radius: 5px;
            font-weight: bolder;
        }

        .negrito {
            font-weight: 800;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
            margin-bottom: 50px;
            margin-top: 100px;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        tr {
            border: 1px solid blue;
        }

        .col-25 {
            width: 25%;
        }

        .col-50 {
            width: 50%;
        }

        .col-100 {
            width: 100%;
        }

        .bl {
            border-left: 1px solid black;
        }

        .br {
            border-right: 1px solid black;
        }

        .bolder {
            font-weight: 700;
        }

        .contentor {
            width: 100%;
            margin: 0 auto;
        }

        .contentor .linha1 {
            width: 100%;
        }

        .linha2 {
            width: 50%;
        }
    </style>


    <div class="container border border-dark p-2 my-5 ">

        <form class='container-pdf'>
            <div class="row p-2" style="border-bottom:3px solid #000000">
                <div class="col-6">
                    <a class="navbar-brand" href="/">
                        <img src="/img/tcul_ico-300x116.png" width="100px" height="40px"
                            class="d-inline-block align-top" alt="">
                        Tecul Frota
                    </a>
                </div>
                <div class="col-6 d-none">
                    <span class="float-end">Turno:xxxxxxx</span>
                </div>
            </div>

            <div class="row p-1" style="border-bottom:3px solid #000000">
                <div class="col-6">
                    <h3> Checklist Rapido do veiculo / {{ $portaria[0]->portaria_tipo }}</h3>
                </div>
                <div class="col-6">
                    <div class="float-end p-1" style="border-left:3px solid #000000">Data:{{ $portaria[0]->data }}
                    </div>
                    <div class="float-end p-1" style="border-left:3px solid #000000">Hora:{{ $portaria[0]->hora }}
                    </div>
                </div>
            </div>

            <div class="row" style="border-bottom:3px solid #000000">

                <div class="col-6">
                    <div class="row p-2">
                        <div class="col-sm-6 col-md-6  col-lg-6" style="border:0px solid #000000">
                            <label class="text-center">Mototista</label>
                            <select id="select_tipo" name="tipo" class="form-select">
                                <option value="Entrada">{{ $portaria[0]->motorista_nome }}</option>
                            </select>
                        </div>
                        <div class=" col-md-6 col-sm-6 col-lg-6" style="border:0px solid #000000">
                            <label class="">MEC</label>
                            <select id="select_motoristas" name="tipo" class="form-select">
                                <option value="Entrada">{{ $portaria[0]->motorista_numero_mecanografico }}</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="col-6" style="border-left:3px solid #000000">
                    <div class="row p-2">
                        <div class="col-md-6 col-sm-6 col-lg-6" style="border:0px solid #000000">
                            <label class="text-center">Cobrador</label>
                            <select id="select_cobrador" name="tipo" class="form-select">
                                <option value="Entrada">{{ $portaria[0]->cobrador_nome }}</option>
                            </select>
                        </div>
                        <div class=" col-md-6 col-sm-6 col-lg-6" style="border:0px solid #000000">
                            <label class="text-center">MEC</label>
                            <select id="select_cobrador" name="tipo" class="form-select">
                                <option value="Entrada">{{ $portaria[0]->cobrador_numero_mecanografico }}</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row" style="border-bottom:3px solid #000000">

                <div class="col-6">
                    <div class="row p-2">
                        <div class="col-md-6 col-sm-6 col-lg-6" style="border:0px solid #000000">
                            <label class="text-center">Matricula</label>
                            <select id="select_cobrador" name="tipo" class="form-select">
                                <option value="Entrada">{{ $portaria[0]->matricula }}</option>
                            </select>
                        </div>
                        <div class=" col-md-6 col-sm-6 col-lg-6" style="border:0px solid #000000">
                            <label class="">Prefixo</label>
                            <select id="select_cobrador" name="tipo" class="form-select">
                                <option value="Entrada">{{ $portaria[0]->prefixo }}</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="col-6" style="border-left:3px solid #000000">
                    <div class="row p-2">
                        <div class="col-md-6 col-sm-6 col-lg-6" style="border:0px solid #000000">
                            <label class="text-center">Marca</label>
                            <select id="select_cobrador" name="tipo" class="form-select">
                                <option value="Entrada">{{ $portaria[0]->marca }}</option>
                            </select>
                        </div>
                        <div class=" col-md-6 col-sm-6 col-lg-6" style="border:0px solid #000000">
                            <label class="text-center">kilometragem</label>
                            <select id="select_cobrador" name="tipo" class="form-select">
                                <option value="Entrada">{{ $portaria[0]->kilometragem }}</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row p-2" style="border-bottom:3px solid #000000">
                <div class="col-12">
                    <div class="form-floating">
                        <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;" disabled> {{ $portaria_descricao }}</textarea>
                        <label for="floatingTextarea mb-5">Breve considreçoes da anormalias</label>
                    </div>
                </div>
            </div>

            <div class="row p-1 bg-danger" style="border-bottom:3px solid #000000;">
                <div class="col-12">
                    <h4 class="text-white">Anormalias apresentadas pelo veiculo</h4>
                </div>
            </div>

            <div class="row p-1 ">
                <div class="col-12">
                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Advanced Form Elements -->
                                        <div class="row mb-5">
                                            <div class="col-sm-10">

                                                @foreach ($portaria_checklist as $checklist)
                                                    <div class="row mb-3">
                                                        <div class="col-sm-10">
                                                            <div class="form-check">
                                                                <input id="{{ $checklist->id_checklist }}"
                                                                    class="form-check-input larger" type="checkbox"
                                                                    name="item_check[]"
                                                                    value="{{ $checklist->id_checklist }}"
                                                                    @if ($checklist->item_selecionado == 1) checked @endif>
                                                                <label class="form-check-label" for="">
                                                                    {{ $checklist->nome_item }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </section>
                </div>
            </div>

    </div>
    </form>
    </div>
    </main><!-- End #main -->
    </div>

</body>

</html>
