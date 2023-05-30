<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $portaria[0]->prefixo }}</title>

    <style>
        @media dompdf {
            * {
                line-height: 1.2;
            }
        }

        .checkbox:checked:before {
            background-color: rgb(50, 191, 226);
            accent-color: #9b59b6;
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

        .bb {
            border-bottom: 5px solid black;
        }

        .bolder {
            font-weight: 700;
        }

        .contentor {
            width: 100%;
            margin: 0 auto;
        }

        .linha1 {
            width: 100%;
        }

        .linha2 {
            width: 50%;
        }

        span.previous {
            float: left;
        }

        span.next {
            float: right;
        }

        p.month {
            text-align: center;
        }
    </style>

</head>

<body>

    <div class="container">
        <table style="width:100%;margin-top:0;margin-bottom:0;">
            <tr style="border:1px solid #FFF">
                <td style="width:70%;font-size:14px;">
                    <span class="">{{ date('Y-m-d H:i:s') }} {{ $portaria[0]->nome_base }}</span>
                </td>
            </tr>
            <tr style="border:1px solid #FFF">
                <td style="width:40%">
                    <span class="bolder">
                        <img src="{{ public_path('/img/tcul_ico-300x116.png') }}" alt="BTS" width="100px"
                            height="40px">
                    </span>
                </td>
                <td style="width:60%">
                    Supervisor : {{ $portaria[0]->supervisor_nome }} {{ $portaria[0]->supervisor_sobrenome }}
                </td>
            </tr>

            <tr style="border:0px solid #000000;">

                <td style="width:15%">
                    <p style="border:0px solid #0000002a;border-radius:2%;padding:2px;">
                        <span class="bolder">Tipo os:</span>{{ $portaria[0]->tipo_os }}
                    </p>
                    <p style="border:0px solid #0000002a;border-radius:2%;padding:2px;">
                        <span class="bolder">veiculo:</span>{{ $portaria[0]->prefixo }}
                    </p>
                </td>

                <td style="width:15%">
                    <p style="border:0px solid #0000002a;border-radius:2%;padding:2px;">
                        <span class="bolder">Data:</span>
                        Data:{{ date('d/m/Y H:m:s', strtotime($portaria[0]->dataHora)) }}
                    </p>
                    <p style="border:0px solid #0000002a;border-radius:2%;padding:2px;">
                        <span class="bolder">Matricula:</span>{{ $portaria[0]->matricula }}
                    </p>
                </td>

            </tr>

            <tr style="border:0px solid #000000;">
                <td style="width:100%;text-align:center;font-size:20pt" colspan="12">
                    <span class="bolder">Serviços Requesitados</span>
                </td>
            </tr>

        </table>
        <table style="width:100%;margin-bottom:0;margin-top:0">

            <tr style="border:3px solid #000000;background-color:rgba(244, 3, 3, 0.979);color:#FFF;">
                <td style="width:50%; border-left:3px solid #000000" class="bolder">
                    Serviços
                </td>
                <td style="width:50%; border-left:3px solid #000000" class="bolder">
                    Descrição
                </td>
            </tr>

            @foreach ($servicos_requesitados as $servico)
                <tr style="border:3px solid #000000">
                    <td style="width:50%; border-left:3px solid #000000">
                        {{ $servico->nome_servico }}
                    </td>
                    <td style="width:50%; border-left:3px solid #000000">
                        {{ $servico->descricao }}
                    </td>
                </tr>
            @endforeach
        </table>

        <table style="width:100%;margin-top:50px;margin-bottom:0;">
            <tr style="border:3px solid #000000">
                <td style="width:100% border-left:3px solid #000000">
                    <textarea class="form-control" placeholder="Address" id="floatingTextarea" style="height: 100px;" disabled> {{ $portaria_descricao }}</textarea>
                </td>

            </tr>
        </table>
        <table style="width:100%;margin-top:0;margin-bottom:0;">
            <tr style="border:2px solid #000000;background-color:red">
                <td style="width:100% border-left:3px solid #000000;">
                    <label class="bolder" style="color:#FFF;text-align:center;font-size:14pt;">
                        Inspenção / Checklist
                    </label>
                    <input id="" class="form-check-input larger" type="checkbox" name="item_check[]"
                        value="" style="display:none">
                </td>
            </tr>
            @foreach ($portaria_checklist as $checklist)
                <tr style="border:0px solid #000000;">
                    <td style="width:100% border-left:3px solid #000000;">
                        <input id="{{ $checklist->id_checklist }}" class="form-check-input larger checkbox"
                            type="checkbox" name="item_check[]" value="{{ $checklist->id_checklist }}"
                            @if ($checklist->item_selecionado == 1) checked @endif>
                        <label class="form-check-label" for="">
                            {{ $checklist->nome_item }}
                        </label>
                    </td>
                </tr>
            @endforeach
            <tr style="border:1px solid #FFF">
                <td style="width:70%;font-size:14px;">
                    <span class="">{{ date('Y-m-d H:i:s') }} {{ $portaria[0]->nome_base }} </span>
                </td>

            </tr>

        </table>

        <script type="text/php">
            if (isset($pdf)) {
                   $font = $fontMetrics->getFont("Arial", "bold");
                   $pdf->page_text(555, 745, "Page {PAGE_NUM}/{PAGE_COUNT}", $font, 7, array(0, 0, 0));
                  }
        </script>


</body>

</html>
