<?php

namespace App\Http\Controllers;

use App\Models\manutencao_preventiva_imagens;
use App\Models\Manutencaopreventiva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate as FacadesGate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class ManuPrentivaImagemController extends Controller
{
    //
    public function verImagens($id)
    {
        $manutencao_preventiva_1 = Manutencaopreventiva::findOrFail($id);

          //selecionado as imagens registradas na manutencao_preventiva
          $imagens = DB::table('manutencao_preventiva as mp')
                ->join('manutencao_preventiva_imagens','manutencao_preventiva_imagens.id_preventiva', '=', 'mp.id_preventiva')
                ->select('mp.*', 'manutencao_preventiva_imagens.*')
                ->where('manutencao_preventiva_imagens.id_preventiva', '=', $id)
                ->orderBy('manutencao_preventiva_imagens.id_imagem_preventiva','Desc')->get();

        $manutencao_preventiva = DB::table('manutencao_preventiva as mp')
                ->join('veiculos', 'veiculos.id_veiculo', '=', 'mp.id_veiculo')
                ->select('mp.*', 'veiculos.*')
                ->where('mp.id_preventiva', '=', $id)
                ->orderBy('mp.id_preventiva', 'asc')->get();

          $dados = [
                'imagens' =>  $imagens,
                'dados_manutencao' => $manutencao_preventiva,
                'id_preventiva' =>$manutencao_preventiva[0]->id_preventiva,
                'manutencao_preventiva' => $manutencao_preventiva_1
          ];

          return view('manutencao.imagens.imagens', $dados);
    }

    public function AdcionarImagens(Request $receber)
    {
          $this->validate(
                $receber,
                [
                      'imagens.*' => ['required', 'image', 'mimetypes:image/jpeg,image/png', 'max:10240'],
                ],
          );

          $dados = Manutencaopreventiva::findOrFail($receber->id);

          if (!Gate::allows('update',$dados)) {
                //abort(403);
                return view('pagina_nao_permitido');
          } else {

                $veiculo = DB::table('manutencao_preventiva as mp')
                      ->join('veiculos', 'veiculos.id_veiculo', '=', 'mp.id_veiculo')
                      ->select('mp.*','veiculos.*')
                      ->where('mp.id_preventiva', '=', $receber->id)
                      ->orderBy('mp.id_preventiva', 'DESC')->get();

                $id_preventiva = $receber->id;

                $veiculo = DB::table('veiculos')->where('id_veiculo', '=', $veiculo[0]->id_veiculo)->first();

                if (isset($receber->allFiles()['imagens']) && count($receber->allFiles()['imagens']) > 0) {

                      for ($i = 0; $i < count($receber->allFiles()['imagens']); $i++) {

                            $imagem = $receber->allFiles()['imagens'][$i];

                            $caminho = $imagem->store('imagens/manutencao/preventiva/' . $veiculo->prefixo);
                            // Salvando o caminho da imagem no banco de dados 
                            $preventiva_imagens = new manutencao_preventiva_imagens();
                            $preventiva_imagens->caminho_imagem = $caminho;
                            $preventiva_imagens->id_preventiva = $id_preventiva;
                            $preventiva_imagens->save();
                      }
                }

                return redirect('/manutencao/preventiva/imagens/'.$id_preventiva)->with('msg', 'Cadastro relizado com sucesso');
          }
    }

    public function DeletarImagem($id)
      {
            $imagem =  manutencao_preventiva_imagens::findOrFail($id);
            //dd($id);
            $caimniho_do_arquivo = Storage::path($imagem->caminho_imagem);
            // s3 $caimniho_do_arquivo = Storage::disk('s3')->url($imagem->caminho_imagem);
            $dados_os =  Manutencaopreventiva::findOrFail($imagem->id_preventiva);
            // verificando se o usuario tem permissao para apagar
            if (!Gate::allows('update', $dados_os)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {
                  if (file_exists($caimniho_do_arquivo)) {
                        // Primeiro apgando arquivo do servidor

                        if (Storage::delete($caimniho_do_arquivo)) {
                              // segunfo apapgando arquivo do banco de dados
                              if ( manutencao_preventiva_imagens::findOrFail($id)->delete()) {
                                    return redirect('/manutencao/preventiva/imagens/'.$imagem->id_preventiva)->with('msg', 'Arquivo 
                                    deletado com Sucesso');
                              } else {
                                    return redirect('/manutencao/preventiva/imagens/'.$imagem->id_preventiva)->with('ERRO', 'Erro ao apagar aqrquivo da base de dados tente novamente ');
                              }
                        } else {
                              return redirect('/manutencao/preventiva/imagens/'.$imagem->id_preventiva)->with('ERRO', 'Erro ao apagar aqrquivo do Servidor tente novamente ');
                        }
                  } else {
                        return redirect('/manutencao/preventiva/imagens/'.$imagem->id_preventiva)->with('ERRO', 'Arquivo não econtrado');
                  }
            }
      }

      public function verImagem($id)
      {
            //selecionado as imagens registradas na portaria

            $imagem = manutencao_preventiva_imagens::findOrFail($id);

            $dados = Manutencaopreventiva::findOrFail($imagem->id_preventiva);

            if (!Gate::allows('update', $dados)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {

                 $manutencao_preventiva = DB::table('manutencao_preventiva as mp')
                  ->join('veiculos', 'veiculos.id_veiculo', '=', 'mp.id_veiculo')
                  ->select('mp.*','veiculos.*')
                  ->where('mp.id_preventiva', '=', $imagem->id_preventiva)
                  ->orderBy('mp.id_preventiva', 'DESC')->get();

                  $dados = [
                        'imagem' =>  $imagem,
                        'manutencao_preventiva' =>  $manutencao_preventiva ,
                        'id_preventiva' =>  $manutencao_preventiva[0]->id_preventiva,
                        'dados_os' => $dados,
                  ];

                  return view('manutencao.imagens.editar', $dados);
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

            $imagem = manutencao_preventiva_imagens::findOrFail($receber->id);

            $camniho_do_arquivo = Storage::path($imagem->caminho_imagem);

            $dados_portaria = Manutencaopreventiva::findOrFail($imagem->id_preventiva);

            
            $veiculo = DB::table('manutencao_preventiva as mp')
            ->join('veiculos','veiculos.id_veiculo','=','mp.id_veiculo')
            ->select('mp.*','veiculos.*')
            ->where('mp.id_preventiva', '=', $imagem->id_preventiva)
            ->orderBy('mp.id_preventiva', 'DESC')->get();

          //  dd($veiculo);

            // verificando se o usuario tem permissao para editar dados da portaria 
            if (!Gate::allows('update', $dados_portaria)) {
                  //abort(403);
                  return view('pagina_nao_permitido');
            } else {

                  if (file_exists($camniho_do_arquivo)) {
                        // Apagando imagem do servidor
                    Storage::delete($imagem->caminho_imagem);

                      $veiculo = DB::table('manutencao_preventiva as mp')
                        ->join('veiculos','veiculos.id_veiculo','=','mp.id_veiculo')
                        ->select('mp.*','veiculos.*')
                        ->where('mp.id_preventiva', '=', $imagem->id_preventiva)
                        ->orderBy('mp.id_preventiva', 'DESC')->get();

                        $caminiho  = $receber->imagem->store('imagens/manutencao/preventiva/'.$veiculo[0]->prefixo);

                        $dados_actulizar = [
                              'caminho_imagem' => $caminiho,
                        ];
                      
                   $Actulizar_imagem = DB::table('manutencao_preventiva_imagens')->where('id_imagem_preventiva', $receber->id)->update($dados_actulizar);

                        if ($Actulizar_imagem) {
                              return redirect('manutencao/preventiva/imagens/editar/'.$receber->id)->with('msg', 'Imagem actualizada com sucesso');
                        } else {
                              return redirect('manutencao/preventiva/imagens/editar/'.$receber->id)->with('ERRO', 'Erro ao actulizar imgem na base de dados');
                        }
                  } else {

                        return redirect('manutencao/preventiva/imagens/'.$imagem->id_preventiva)->with('ERRO', 'Erro ao apagar arquivo do Servidor tente novamente ');
                  }
            }
      }
}
