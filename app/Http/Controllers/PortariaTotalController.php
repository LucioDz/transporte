<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortariaRequest;
use App\Http\Requests\PortariaImagensRequest;
use App\Models\Portaria;
use App\Models\veiculo;
use App\Models\Funcionario;
use App\Models\Checklist;
use App\Models\portaria_cheklist;
use App\Models\portaria_imagens;
use App\Models\portaria_veiculos_afectados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

//use PDF;

class PortariaTotalController extends Controller
{

      /***    Funcionario    **/
      public function ListarTodasSaidasFuncionario($id)
      {
            $funcionario = Funcionario::findOrFail($id);
            $perfil = 0;

            if ($funcionario->funcionario_tipo == "motorista") {
                  $perfil = 'fk_id_motorista';
            } elseif ($funcionario->funcionario_tipo == "cobrador") {
                  $perfil = 'fk_id_ajudante';
            } elseif ($funcionario->funcionario_tipo == "supervisor") {
                  $perfil = 'fk_id_supervisor';
            } elseif ($funcionario->funcionario_tipo == "administrador_base") {
                  $perfil = 'fk_id_supervisor';
            } elseif ($funcionario->funcionario_tipo == "administrador_seniorr") {
                  $perfil = 'fk_id_supervisor';
            } else {
                  abort(403);
            }
            $portaria2  = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
                  ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
                  ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'bases.*',
                        'provincias.*',
                        'municipios.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
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
                  )->where($perfil, '=', $id)->orderBy('id_portaria', 'Desc')
                  ->where('portaria_tipo', '=', 'Saida')->orderBy('id_portaria', 'Desc')->paginate();

            $dados = [
                  'portaria' => $portaria2
            ];

            return view('portaria.listar', $dados);
      }

      public function ListarTodasEntradasFuncionario($id)
      {
            $funcionario = Funcionario::findOrFail($id);
            $perfil = 0;

            if ($funcionario->funcionario_tipo == "motorista") {
                  $perfil = 'fk_id_motorista';
            } elseif ($funcionario->funcionario_tipo == "cobrador") {
                  $perfil = 'fk_id_ajudante';
            } elseif ($funcionario->funcionario_tipo == "supervisor") {
                  $perfil = 'fk_id_supervisor';
            } elseif ($funcionario->funcionario_tipo == "administrador_base") {
                  $perfil = 'fk_id_supervisor';
            } elseif ($funcionario->funcionario_tipo == "administrador_seniorr") {
                  $perfil = 'fk_id_supervisor';
            } else {
                  abort(403);
            }

            $portaria2  = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
                  ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
                  ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'bases.*',
                        'provincias.*',
                        'municipios.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
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
                  )->where($perfil, '=', $id)
                  ->where('portaria_tipo', '=', 'Entrada')->orderBy('id_portaria', 'Desc')->paginate();

            $dados = [
                  'portaria' => $portaria2
            ];

            return view('portaria.listar', $dados);
      }

      public function ListarTodasEntradasSaidasFuncionario($id)
      {
            $funcionario = Funcionario::findOrFail($id);
            $perfil = 0;

            if ($funcionario->funcionario_tipo == "motorista") {
                  $perfil = 'fk_id_motorista';
            } elseif ($funcionario->funcionario_tipo == "cobrador") {
                  $perfil = 'fk_id_ajudante';
            } elseif ($funcionario->funcionario_tipo == "supervisor") {
                  $perfil = 'fk_id_supervisor';
            } elseif ($funcionario->funcionario_tipo == "administrador_base") {
                  $perfil = 'fk_id_supervisor';
            } elseif ($funcionario->funcionario_tipo == "administrador_seniorr") {
                  $perfil = 'fk_id_supervisor';
            } else {
                  abort(403);
            }

            $portaria2  = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
                  ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
                  ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'bases.*',
                        'provincias.*',
                        'municipios.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
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
                  )->where($perfil,'=',$id)->orderBy('id_portaria','Desc')->paginate();

            $dados = [
                  'portaria' => $portaria2
            ];

            return view('portaria.listar', $dados);
      }

  
       /******** Veiculo ******/
      public function ListarTodasSaidasVeiculo($id)
      {
          
            $portaria2  = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
                  ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
                  ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'bases.*',
                        'provincias.*',
                        'municipios.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
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
                  )->where('fk_id_veiculo', '=', $id)
                  ->where('portaria_tipo', '=', 'Saida')->orderBy('id_portaria', 'Desc')->paginate();

            $dados = [
                  'portaria' => $portaria2
            ];

            return view('portaria.listar', $dados);
      }

      public function ListarTodasEntradas_SaidasVeiculo($id)
      {
          
            $portaria2  = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
                  ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
                  ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'bases.*',
                        'provincias.*',
                        'municipios.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
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
                  )->where('fk_id_veiculo', '=', $id)->orderBy('id_portaria', 'Desc')->paginate();

            $dados = [
                  'portaria' => $portaria2
            ];

            return view('portaria.listar', $dados);
      }

      public function ListarTodasEntradasVeiculo($id)
      {
          
            $portaria2  = DB::table('portaria as P')
                  ->join('funcionarios as motorista', 'motorista.id_funcionario', '=', 'P.fk_id_motorista')
                  ->join('funcionarios as cobrador', 'cobrador.id_funcionario', '=', 'P.fk_id_ajudante')
                  ->join('funcionarios as supervisor', 'supervisor.id_funcionario', '=', 'P.fk_id_supervisor')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->join('bases', 'bases.id_base', '=', 'veiculos.id_base')
                  ->join('municipios', 'municipios.id_municipio', '=', 'bases.id_municipio')
                  ->join('provincias', 'provincias.id_provincia', '=', 'municipios.id_provincia')
                  ->select(
                        'P.*',
                        'veiculos.*',
                        'bases.*',
                        'provincias.*',
                        'municipios.*',
                        'cobrador.id_funcionario as id_cobrador',
                        'cobrador.nome as cobrador_nome',
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
                  )->where('fk_id_veiculo', '=', $id)
                  ->where('portaria_tipo', '=', 'Entrada')->orderBy('id_portaria', 'Desc')->paginate();

            $dados = [
                  'portaria' => $portaria2
            ];

            return view('portaria.listar', $dados);
      }

}
