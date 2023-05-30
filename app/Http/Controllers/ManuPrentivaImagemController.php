<?php

namespace App\Http\Controllers;

use App\Models\Manutencaopreventiva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManuPrentivaImagemController extends Controller
{
    //
    public function verImagens($id)
    {
        $manutencao_preventiva = Manutencaopreventiva::findOrFail($id);

          //selecionado as imagens registradas na manutencao_preventiva
          $imagens = DB::table('manutencao_preventiva as mp')
                ->join('manutencao_preventiva_imagens','manutencao_preventiva_imagens.id_preventiva', '=', 'mp.id_preventiva')
                ->select('mp.*', 'manutencao_preventiva_imagens.*')
                ->where('manutencao_preventiva_imagens.id_preventiva', '=', $id)
                ->orderBy('mp.id_preventiva', 'DESC')->get();

          $ordemServico = DB::table('manutencao_preventiva as mp')
                ->join('veiculos', 'veiculos.id_veiculo', '=', 'mp.id_veiculo')
                ->select('mp.*', 'veiculos.*')
                ->where('mp.id_preventiva', '=', $id)
                ->orderBy('mp.id_preventiva', 'DESC')->get();

          $dados = [
                'imagens' =>  $imagens,
                'ordemServico' => $ordemServico,
                'id_os' => $ordemServico[0]->id_preventiva,
                'dados_ordemServico' => $manutencao_preventiva
          ];

          return view('manutencao.imagens.imagens', $dados);
    }
}
