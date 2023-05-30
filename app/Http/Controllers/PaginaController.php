<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FuncionarioRequest;
use App\Http\Requests\ServicosRequisitadosRequest;
use App\Models\Funcionario;
use App\Models\User;
use App\Models\Base;
use App\Models\ServicosRequisitados;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaginaController extends Controller
{
    public function index()
    { 
        
        $bases = DB::table('bases')->get();
       
        $funcionarios = DB::table('funcionarios')->where('id_base', '=',  Auth::user()->funcionario->id_base)->get();
        $veiculos = DB::table('veiculos')->where('id_base', '=',  Auth::user()->funcionario->id_base)->get();
        $checklist = DB::table('checklists')->get();

         //filtrando dados da portaria
         $portaria = DB::table('portaria as P')
         ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
         ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
         ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
         ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
         ->join('bases as base', 'base.id_base', '=', 'veiculos.id_base')
         ->select(
               'P.*',
               'base.*',
               'veiculos.*',
               'cobrador.id_funcionario as id_cobrador',
               'cobrador.nome as cobrador_nome',
               'cobrador.sobrenome as cobrador_sobrenome',
               'cobrador.sobrenome as cobrador_sobrenome',
               'cobrador.numero_mecanografico as cobrador_numero_mecanografico',
               'motorista.id_funcionario as id_motorista',
               'motorista.nome as motorista_nome',
               'motorista.sobrenome as motorista_sobrenome',
               'motorista.numero_mecanografico as motorista_numero_mecanografico',
               'supervisor.id_funcionario as id_supervisor',
               'supervisor.numero_mecanografico as supervisor_numero_mecanografico',
               'supervisor.nome as supervisor_nome',
               'supervisor.sobrenome as supervisor_sobrenome',
        )->where('supervisor.id_base', '=',  Auth::user()->funcionario->id_base)
        ->orderBy('P.id_portaria', 'DESC')->paginate(10);

        $dados = [
            'bases' => $bases,
            'funcionarios' => $funcionarios,
            'veiculos' =>  $veiculos,
            'checklist' =>  $checklist,
            'portaria' =>  $portaria
        ];
        
        return view('welcome',$dados);

    }


 
}
