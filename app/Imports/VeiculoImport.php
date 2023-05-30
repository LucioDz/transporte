<?php

namespace App\Imports;

use App\Models\veiculo;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;

class VeiculoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       // dd($row);

        return new veiculo([
            'id_base' => Auth::user()->funcionario->id_base,
            'marca' => $row[0],
            'prefixo' => $row[1],
            'matricula' => $row[2],
            'modelo' => $row[3],
            'motor' => $row[4],
            'chassis' => $row[5],
            'lugares_sentados' => $row[6],
            'lugares_em_pe' => $row[7],
            'lotacao' => $row[8],
            'ano' => $row[9],
            'pais' => $row[10],
            'kilometragem' => $row[11],
            'situacao' => $row[12],
            'registrado_por' => Auth::user()->funcionario->id_funcionario,
        ]);
    }
}

