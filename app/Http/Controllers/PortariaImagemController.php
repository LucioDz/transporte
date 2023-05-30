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

class PortariaImagemController extends Controller
{

      public function verImagens($id)
      {

            $dados_portaria = portaria::findOrFail($id);

            //selecionado as imagens registradas na portaria
            $imagens = DB::table('portaria')
            ->join('portaria_imagens', 'portaria_imagens.fk_id_portaria', '=', 'portaria.id_portaria')
            ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'portaria.fk_id_veiculo')
            ->select('portaria.*', 'portaria_imagens.*', 'veiculos.*')->where('portaria_imagens.fk_id_portaria', '=', $id)
            ->orderBy('portaria_imagens.id_portaria_imagem', 'DESC')->get();

            $portaria = DB::table('portaria')
            ->join('veiculos', 'veiculos.id_veiculo', '=', 'portaria.fk_id_veiculo')
            ->select('portaria.*', 'veiculos.*')->where('portaria.id_portaria', '=', $id)
            ->orderBy('portaria.id_portaria', 'DESC')->get();

            $dados = [
                  'imagens' =>  $imagens,
                  'portaria' => $portaria,
                  'id_portaria' => $portaria[0]->id_portaria,
                  'dados_portaria' => $dados_portaria
            ];

            return view('portaria.imagens.imagens', $dados);
      }

      public function  AdcionarImagens(PortariaImagensRequest $receber)
      {
            $receber->validated();

            $dados_portaria = portaria::findOrFail($receber->id);

            if (!Gate::allows('update-portaria', $dados_portaria)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {

            
              $veiculo = DB::table('portaria as P')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'P.fk_id_veiculo')
                  ->select('P.*', 'veiculos.*',)->where('P.id_portaria', '=', $receber->id)->get();

                  $id_portaria = $receber->id;

                  $veiculo = DB::table('veiculos')->where('id_veiculo', '=', $veiculo[0]->id_veiculo)->first();

                  if (isset($receber->allFiles()['imagens']) && count($receber->allFiles()['imagens']) > 0) {

                        for ($i = 0; $i < count($receber->allFiles()['imagens']); $i++) {
                              $imagem = $receber->allFiles()['imagens'][$i];
                              $caimniho = $imagem->store('imagens/veiculos/' . $veiculo->prefixo);
                              $caimniho_do_arquivo = $caimniho;

                              $portaria_imagem =  new portaria_imagens();
                              $portaria_imagem->caminho_imagem = $caimniho_do_arquivo;
                              $portaria_imagem->fk_id_portaria = $id_portaria;
                              $portaria_imagem->save();
                        }
                  }

                  return redirect('portaria/imagens/' . $id_portaria)->with('msg', 'Cadastro relizado com sucesso');
            }
      }

      public function verImagem($id)
      {
            //selecionado as imagens registradas na portaria
            $imagem = portaria_imagens::findOrFail($id);

            $dados_portaria = portaria::findOrFail($imagem->fk_id_portaria);

            if (!Gate::allows('update-portaria', $dados_portaria)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {

                  $portaria = DB::table('portaria')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'portaria.fk_id_veiculo')
                  ->select('portaria.*', 'veiculos.*')->where('portaria.id_portaria', '=', $imagem->fk_id_portaria)
                  ->orderBy('portaria.id_portaria', 'DESC')->get();

                 // dd($portaria);
            
                  $dados = [
                        'imagem' =>  $imagem,
                        'portaria' => $portaria,
                        'id_portaria' => $portaria[0]->id_portaria,
                        'dados_portaria' => $dados_portaria,
                  ];

                  return view('portaria.imagens.editar', $dados);
            }
      }

      public function ActulizarImagem(request $receber)
      {
            $imagem = portaria_imagens::findOrFail($receber->id);

            $camniho_do_arquivo = Storage::path($imagem->caminho_imagem);

            $dados_portaria = portaria::findOrFail($imagem->fk_id_portaria);

            // verificando se o usuario tem permissao para editar dados da portaria 
            if (!Gate::allows('update-portaria', $dados_portaria)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {

                  if (file_exists($camniho_do_arquivo)) {
                        // Apango primerio do servidor
                        Storage::delete($imagem->caminho_imagem);
                  }

                  $this->validate(
                        $receber,
                        [
                              'imagem' => ['required'],
                              'imagem' => ['photo' => 'mimetypes:image/jpeg,image/png'],
                              'imagem' => ['photo' => 'mimes:jpg,bmp,png', 'max:10240'],
                        ],
                        [
                              'imagem.required' => 'Selecione a Imagem',
                              'imagem.mimetypes' => 'Extensão não Permitida',
                              'imagem.mimes' => 'Extensão não Permitida',
                              'imagem.max' => 'A foto de deve ter no maximo 10 megabytes',
                        ]
                  );
              
                  $veiculo = DB::table('portaria')
                  ->join('veiculos as veiculos', 'veiculos.id_veiculo', '=', 'portaria.fk_id_veiculo')
                  ->select('portaria.*', 'veiculos.*')->where('portaria.id_portaria', '=', $imagem->fk_id_portaria)
                  ->orderBy('portaria.id_portaria', 'DESC')->get();

                  $caimniho  = $receber->imagem->store('imagens/veiculos/' . $veiculo[0]->prefixo);

                  $dados_actulizar = [
                        'caminho_imagem' => $caimniho,
                  ];

                  $Actulizar_imagem = DB::table('portaria_imagens')->where('id_portaria_imagem',$receber->id)->update($dados_actulizar);

                  if ($Actulizar_imagem) {
                        return redirect('/portaria/imagens/editar/' . $receber->id)->with('msg', 'Imagem actualizada com sucesso');
                  }
            }
      }

      public function BaixarImagem($id)
      {
            $imagem = portaria_imagens::findOrFail($id);
            $baixar = Storage::disk('s3')->url($imagem->caminho_imagem);
            $caimniho_do_arquivo = Storage::path($baixar);
            
            $headers = array(
                  'Content-Disposition' => 'inline',
            );

            if (file_exists($caimniho_do_arquivo)) {
                  return Storage::download($caimniho_do_arquivo);
                  exit;
            } else {
                  return redirect('portaria/imagens/' . $imagem->fk_id_portaria)->with('ERRO', 'Arquivo não econtrado');
            }
            //return Storage::download($filepath);
            //return dd($filepath);
            // return view('portaria.listar', $dados);
      }

      public function DeletarImagem($id)
      {
            $imagem = portaria_imagens::findOrFail($id);
            $filepath = $imagem->caminho_imagem;
           //$caimniho_do_arquivo = Storage::path($imagem->caminho_imagem);
            $caimniho_do_arquivo = Storage::disk('s3')->url($imagem->caminho_imagem);
  
            $dados_portaria = portaria::findOrFail($imagem->fk_id_portaria);
            // verificando se o usuario tem permissao para apagar dados da portaria 
            if (!Gate::allows('update-portaria', $dados_portaria)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {
                  if (file_exists($caimniho_do_arquivo)) {
                        // Primeiro apgando arquivo do servidor
                        if (Storage::delete($caimniho_do_arquivo)) {
                              // segunfo apapgando arquivo do banco de dados
                              if (portaria_imagens::findOrFail($id)->delete()) {
                                    return redirect('portaria/imagens/' . $imagem->fk_id_portaria)->with('msg', 'Arquivo 
                                    deletado com Sucesso');
                              } else {
                                    return redirect('portaria/imagens/' . $imagem->fk_id_portaria)->with('ERRO', 'Erro ao apagar aqrquivo da base de dados tente novamente ');
                              }
                        } else {
                              return redirect('portaria/imagens/' . $imagem->fk_id_portaria)->with('ERRO', 'Erro ao apagar aqrquivo do Servidor tente novamente ');
                        }
                  } else {
                        return redirect('portaria/imagens/' . $imagem->fk_id_portaria)->with('ERRO', 'Arquivo não econtrado');
                  }
            }
      }
}
