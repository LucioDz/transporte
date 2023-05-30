<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\cheklistRequest;
use App\Models\Checklist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class cheklistController extends Controller
{
    public function cadastrar()
    {

        return view('checklist.cadastrar');
    }

    public function store(cheklistRequest $receber)
    {

        // validando os dados do formulario

        $receber->validated();

        $checklist = new Checklist();

        $checklist->nome_item =  $receber->nome;
        $checklist->registrado_por = Auth::user()->id;

        if ($checklist->save()) {
            return redirect('checklist/listar')->with('msg', 'Cadastro relizado com sucesso');
        } else {
            return redirect('checklist/listar')->with('ERRO', 'Erro ao salvar veiculo na Base de dados');
        }
    }

    public function listar()
    {

        $checklists = DB::table('checklists')
            ->orderBy('id_checklist', 'DESC')->paginate(10);

        //dd($funcionarios);

        $dados = [
            'checklists' => $checklists,
        ];

        //dd(Funcionario::where(1));

        return view('checklist.listar', $dados);
    }

    public function deletar_checklist($id_checklist)
    {

        $Checklist = Checklist::findOrFail($id_checklist);

        $Registro_em_uso_portaria = DB::table('portaria_cheklist')->where('fk_id_item_checklist', $id_checklist)->exists();

        if (!Gate::allows('delete', $Checklist)) {

            return view('pagina_nao_permitido');
        } else {

            if ($Registro_em_uso_portaria > 0) {
                return redirect('/checklist/listar')->with('ERRO', 'Registro não pode ser excluído por estar
                relacionado com os dados da portaria');
            } else {

                if (Checklist::findOrFail($id_checklist)->delete()) {
                    return redirect('/checklist/listar')->with('msg', 'Excluido com sucesso');
                } else {
                    return redirect('/checklist/listar')->with('ERRO','Erro ao excluir dados tente novamente');
                }
            }
        }
    }

    public function pesquisar(Request $receber)
    {
        $this->validate(
            $receber,
            [
                'pesquisar' => 'required'
            ],
            [
                'pesquisar.required' => 'Preecnha o campo pesquisar',
            ]
        );


        $checklists = Checklist::where('nome_item', 'LIKE', '%' . $receber->pesquisar . '%')
            ->paginate();

        //dd($funcionarios);
        $dados = [
            'checklists' =>  $checklists,
            'pesquisar' => $checklists
        ];
        //dd(Funcionario::where(1));

        return view('checklist.listar', $dados);
    }

    public function editar_checklist($id_funcionario)
    {
        $checklist = Checklist::findOrFail($id_funcionario);

        if (!Gate::allows('editar',$checklist)) {

            return view('pagina_nao_permitido');
        } else {

            $dados = [
                'checklist' =>    $checklist,
            ];

            return view('checklist.editar', $dados);
        }
    }

    public function actulizar_checklist(cheklistRequest  $receber)
    {

        $receber->validated();

        $dados_actulizar = [
            'nome_item' =>  $receber->nome,
        ];


        $checklist = DB::table('checklists')->where('id_checklist', $receber->id)->update($dados_actulizar);

        if ($checklist) {
            return redirect('/checklist/listar')->with('msg', 'Dados Actulizado com sucesso');
        } else {
            return redirect('/checklist/listar')->with('ERRO', 'Erro ao actulizar dados tente novamente');
        }
    }
}
