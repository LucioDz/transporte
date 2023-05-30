<?php

namespace App\Http\Controllers;

use App\Http\Requests\PortariaRequest;
use App\Http\Requests\PortariaImagensRequest;
use App\Models\Portaria;
use App\Models\veiculo;
use App\Models\Funcionario;
use App\Models\Checklist;
use App\Models\ordem_servico_imagens;
use App\Models\OrdemServico;
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

class OrdemSericoImagemController extends Controller
{
      public function verImagens($id)
      {
            $dados_ordemServico = OrdemServico::findOrFail($id);

            //selecionado as imagens registradas na portaria
            $imagens = DB::table('ordem_servico')
                  ->join('ordem_servico_imagens', 'ordem_servico_imagens.id_os', '=', 'ordem_servico.id_os')
                  ->select('ordem_servico.*', 'ordem_servico_imagens.*')
                  ->where('ordem_servico_imagens.id_os', '=', $id)
                  ->orderBy('ordem_servico_imagens.id_os', 'DESC')->get();

            $ordemServico = DB::table('ordem_servico as OS')
                  ->join('veiculos', 'veiculos.id_veiculo', '=', 'OS.id_veiculo')
                  ->select('OS.*', 'veiculos.*')
                  ->where('OS.id_os', '=', $id)
                  ->orderBy('OS.id_os', 'DESC')->get();

            $dados = [
                  'imagens' =>  $imagens,
                  'ordemServico' => $ordemServico,
                  'id_os' => $ordemServico[0]->id_os,
                  'dados_ordemServico' => $dados_ordemServico
            ];

            return view('OrdemServico.imagens.imagens', $dados);
      }

      public function AdcionarImagens(Request $receber)
      {
            $this->validate(
                  $receber,
                  [
                        'imagens.*' => ['required', 'image', 'mimetypes:image/jpeg,image/png', 'max:10240'],
                  ],
            );

            $dados_portaria = OrdemServico::findOrFail($receber->id);

            if (!Gate::allows('updateOrdemServico', $dados_portaria)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {

                  $veiculo = DB::table('ordem_servico as OS')
                        ->join('veiculos', 'veiculos.id_veiculo', '=', 'OS.id_veiculo')
                        ->select('OS.*', 'veiculos.*')
                        ->where('OS.id_os', '=', $receber->id)
                        ->orderBy('OS.id_os', 'DESC')->get();

                  $id_os = $receber->id;

                  $veiculo = DB::table('veiculos')->where('id_veiculo', '=', $veiculo[0]->id_veiculo)->first();

                  if (isset($receber->allFiles()['imagens']) && count($receber->allFiles()['imagens']) > 0) {

                        for ($i = 0; $i < count($receber->allFiles()['imagens']); $i++) {

                              $imagem = $receber->allFiles()['imagens'][$i];

                              $caminho = $imagem->store('imagens/ordemServico/veiculos'.$veiculo->prefixo);
                              // Salvando o caminho da imagem no banco de dados
                              $OS_imagem = new ordem_servico_imagens();
                              $OS_imagem->caminho_imagem = $caminho;
                              $OS_imagem->id_os = $id_os;
                              $OS_imagem->save();
                        }
                  }

                  return redirect('os/imagens/' . $id_os)->with('msg', 'Cadastro relizado com sucesso');
            }
      }

      public function verImagem($id)
      {
            //selecionado as imagens registradas na portaria

            $imagem = ordem_servico_imagens::findOrFail($id);

            $dados = OrdemServico::findOrFail($imagem->id_os);

            if (!Gate::allows('updateOrdemServico', $dados)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {

                  $ordemServico = DB::table('ordem_servico as OS')
                        ->join('veiculos', 'veiculos.id_veiculo', '=', 'OS.id_veiculo')
                        ->select('OS.*', 'veiculos.*')
                        ->where('OS.id_os', '=', $imagem->id_os)
                        ->orderBy('OS.id_os', 'DESC')->get();

                  // dd($portaria);

                  $dados = [
                        'imagem' =>  $imagem,
                        'ordemServico' =>  $ordemServico,
                        'id_os' => $ordemServico[0]->id_os,
                        'dados_os' => $dados,
                  ];

                  return view('OrdemServico.imagens.editar', $dados);
            }
      }

      public function ActulizarImagem(request $receber)
      {

            $this->validate(
                  $receber,
                  [
                        'imagem' => ['required', 'image', 'mimetypes:image/jpeg,image/png', 'max:10240'],
                  ],

            );

            $imagem = ordem_servico_imagens::findOrFail($receber->id);

            $camniho_do_arquivo = Storage::path($imagem->caminho_imagem);

            $dados_portaria = OrdemServico::findOrFail($imagem->id_os);

            // verificando se o usuario tem permissao para editar dados da portaria 
            if (!Gate::allows('updateOrdemServico', $dados_portaria)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {

                  if (file_exists($camniho_do_arquivo)) {
                        // Apango primerio do servidor
                        Storage::delete($imagem->caminho_imagem);

                        $veiculo = DB::table('ordem_servico as OS')
                              ->join('veiculos', 'veiculos.id_veiculo', '=', 'OS.id_veiculo')
                              ->select('OS.*', 'veiculos.*')
                              ->where('OS.id_os', '=', $imagem->id_os)
                              ->orderBy('OS.id_os', 'DESC')->get();

                        $caimniho  = $receber->imagem->store('imagens/ordemServico/veiculos/' . $veiculo[0]->prefixo);

                        $dados_actulizar = [
                              'caminho_imagem' => $caimniho,
                        ];

                        $Actulizar_imagem = DB::table('ordem_servico_imagens')->where('id_imagem_os', $receber->id)->update($dados_actulizar);

                        if ($Actulizar_imagem) {
                              return redirect('/os/imagens/editar/' . $receber->id)->with('msg', 'Imagem actualizada com sucesso');
                        } else {
                              return redirect('/os/imagens/editar/' . $receber->id)->with('ERRO', 'Erro ao actulizar imgem na base de dados');
                        }
                  } else {
                        return redirect('os/imagens/' . $imagem->id_os)->with('ERRO', 'Erro ao apagar aqrquivo do Servidor tente novamente ');
                  }
            }
      }

      public function BaixarImagem($id)
      {
            $imagem = ordem_servico_imagens::findOrFail($id);
            //$baixar = Storage::disk('s3')->url($imagem->caminho_imagem);
            $caimniho_do_arquivo = Storage::path($imagem->caminho_imagem);

            $headers = array(
                  'Content-Disposition' => 'inline',
            );

            if (file_exists($caimniho_do_arquivo)) {
                  return Storage::download($imagem->caminho_imagem);
                  exit;
            } else {
                  return redirect('os/imagens/' . $imagem->id_os)->with('ERRO', 'Arquivo não econtrado');
            }
            //return Storage::download($filepath);
            //return dd($filepath);
            // return view('portaria.listar', $dados);
      }

      public function DeletarImagem($id)
      {
            $imagem = ordem_servico_imagens::findOrFail($id);
            //dd($id);
            $caimniho_do_arquivo = Storage::path($imagem->caminho_imagem);
            // s3 $caimniho_do_arquivo = Storage::disk('s3')->url($imagem->caminho_imagem);
            $dados_os = OrdemServico::findOrFail($imagem->id_os);
            // verificando se o usuario tem permissao para apagar
            if (!Gate::allows('updateOrdemServico', $dados_os)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {
                  if (file_exists($caimniho_do_arquivo)) {
                        // Primeiro apgando arquivo do servidor
                        if (Storage::delete($caimniho_do_arquivo)) {
                              // segunfo apapgando arquivo do banco de dados
                              if (ordem_servico_imagens::findOrFail($id)->delete()) {
                                    return redirect('os/imagens/' . $imagem->id_os)->with('msg', 'Arquivo 
                                    deletado com Sucesso');
                              } else {
                                    return redirect('os/imagens/' . $imagem->id_os)->with('ERRO', 'Erro ao apagar aqrquivo da base de dados tente novamente ');
                              }
                        } else {
                              return redirect('os/imagens/' . $imagem->id_os)->with('ERRO', 'Erro ao apagar aqrquivo do Servidor tente novamente ');
                        }
                  } else {
                        return redirect('os/imagens/' . $imagem->id_os)->with('ERRO', 'Arquivo não econtrado');
                  }
            }
      }
}
