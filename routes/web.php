<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\FuncionarioController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\cheklistController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\provinciaController;
use App\Http\Controllers\MuncipioController;
use App\Http\Controllers\PaginaController;
use App\Http\Controllers\portariaController;
use App\Http\Controllers\PortariaImagemController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ManuPrentivaImagemController;
use App\Http\Controllers\OrdemSericoImagemController;
use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\PortariaTotalController;
use App\Http\Controllers\ManutencaoController;
use App\Models\ordem_servico_imagens;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
        'register' => true,
        'verify' => true,
]);

Route::group(['middleware' => 'auth'], function () {

        //Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/', [PaginaController::class, 'index'])->middleware(['auth', 'verified']);

        Route::middleware('can:view,App\Models\Funcionario')->group(function () {
                Route::get('/cadastrar/funcionario', [FuncionarioController::class, 'cadastrar']);
                Route::post('/funcionario/cadastrar', [FuncionarioController::class, 'store']);
                Route::get('/funcionario/listar', [FuncionarioController::class, 'listar']);
                Route::get('/funcionario/listar/base', [FuncionarioController::class, 'listar_base']);
                Route::delete('/funcionario/deletar/{id}', [FuncionarioController::class, 'deletar_usuario']);
                Route::get('/funcionario/editar/{id}', [FuncionarioController::class, 'editar_usuario']);
                Route::put('/funcionario/actualizar/{id}', [FuncionarioController::class, 'actulizar_funcionario']);
                Route::post('/funcionario/pesquisar', [FuncionarioController::class, 'pesquisar']);
                Route::get('/funcionario/pesquisar', [FuncionarioController::class, 'pesquisar']);
                Route::post('/funcionario/pesquisar/base', [FuncionarioController::class, 'pesquisar_base']);
                //Route::post('/register/usuario', [UsuarioController::class, 'create'])->name('register_usuario');
                Route::put('/usuario/update/{id}', [UsuarioController::class, 'update'])->name('update');
                Route::get('/funcionario/editar/{id}', [FuncionarioController::class, 'editar_usuario']);
                Route::get('/funcionario/perfil/{id}', [FuncionarioController::class, 'perfil']);
        });

        //veiculos 
        Route::middleware('can:view,App\Models\Funcionario')->group(function () {
                Route::get('/cadastrar/veiculo', [VeiculoController::class, 'cadastrar']);
                Route::post('/veiculo/cadastrar', [VeiculoController::class, 'store']);
                Route::get('/veiculos/listar', [VeiculoController::class, 'listar']);
                Route::delete('/veiculo/deletar/{id}', [VeiculoController::class, 'deletar_veiculo']);
                Route::get('/veiculo/editar/{id}', [VeiculoController::class, 'editar_veiculo']);
                Route::put('/veiculo/actualizar/{id}', [VeiculoController::class, 'actulizar_veiculo']);
                Route::post('/veiculos/pesquisar', [VeiculoController::class, 'pesquisar']);
                Route::get('/veiculos/pesquisar', [VeiculoController::class, 'pesquisar']);
                Route::get('/veiculos/listar/base', [VeiculoController::class, 'listar_base']);
                Route::get('/veiculos/gerarExel', [VeiculoController::class, 'exportar_exel']);
                Route::post('veiculos/importar/exel', [ImportController::class, 'VeiculoImportar_exel']);
                Route::get('/veiculo/perfil/{id}', [VeiculoController::class, 'perfil']);
        });
        //checklist
        Route::middleware('can:view,App\Models\Funcionario')->group(function () {
                Route::get('/cadastrar/checklist', [cheklistController::class, 'cadastrar']);
                Route::post('/checklist/cadastrar', [cheklistController::class, 'store']);
                Route::get('/checklist/listar', [cheklistController::class, 'listar']);
                Route::delete('/checklist/deletar/{id}', [cheklistController::class, 'deletar_checklist']);
                Route::post('/checklist/pesquisar', [cheklistController::class, 'pesquisar']);
                Route::get('/checklist/pesquisar', [cheklistController::class, 'pesquisar']);
                Route::get('/checklist/editar/{id}', [cheklistController::class, 'editar_checklist']);
                Route::put('/checklist/actualizar/{id}', [cheklistController::class, 'actulizar_checklist']);
        });

        Route::middleware('can:view,App\Models\Funcionario')->group(function () {
                //provincia
                Route::get('/cadastrar/provincia', [provinciaController::class, 'cadastrar']);
                Route::post('/provincia/cadastrar', [provinciaController::class, 'store']);
                Route::delete('/provincia/deletar/{id}', [provinciaController::class, 'deletar_provincia']);
                Route::get('/provincia/editar/{id}', [provinciaController::class, 'editar_provinvia']);
                Route::put('/provincia/actualizar/{id}', [provinciaController::class, 'actulizar_provinvia']);
                //Municipio
                Route::post('/municipo/cadastrar', [MuncipioController::class, 'store']);
                Route::delete('/municipo/deletar/{id}', [MuncipioController::class, 'deletar_municipio']);
                Route::get('/municipo/editar/{id}', [MuncipioController::class, 'editar_municipio']);
                Route::put('/municipo/actualizar/{id}', [MuncipioController::class, 'actulizar_municipio']);
                //base
                Route::get('/cadastrar/base', [BaseController::class, 'cadastrar']);
                Route::post('/base/cadastrar', [BaseController::class, 'store']);
                Route::get('/base/listar', [BaseController::class, 'listar']);
                Route::post('/base/pesquisar', [BaseController::class, 'pesquisar']);
                Route::get('/base/pesquisar', [BaseController::class, 'pesquisar']);
                Route::delete('/base/deletar/{id}', [BaseController::class, 'deletar_base']);
                Route::get('/base/editar/{id}', [BaseController::class, 'editar_base']);
                Route::put('/base/actualizar/{id}', [BaseController::class, 'actulizar_base']);
                Route::get('/base/perfil/{id}', [BaseController::class, 'perfil']);
        });
        //Portaria
        Route::middleware('can:view,App\Models\Portaria')->group(function () {
                //Portaria
                Route::get('/cadastrar/portaria', [portariaController::class, 'cadastrar']);
                Route::post('/portaria/cadastrar', [portariaController::class, 'store']);
                Route::get('/portaria/listar', [portariaController::class, 'ListarRegistros_Do_Supervisor']);
                Route::get('/portaria/listar/base', [portariaController::class, 'listar_minha_base']);

                Route::get('/portaria/listar/EntradasFuncionario/{id}', [PortariaTotalController::class, 'ListarTodasEntradasFuncionario']);
                Route::get('/portaria/listar/SaidasFuncionario/{id}', [PortariaTotalController::class, 'ListarTodasSaidasFuncionario']);
                Route::get('/portaria/listar/TodasEntradasSaidasFuncionario/{id}', [PortariaTotalController::class, 'ListarTodasEntradasSaidasFuncionario']);

                Route::get('/portaria/listar/EntradasVeciulo/{id}', [PortariaTotalController::class, 'ListarTodasEntradasVeiculo']);
                Route::get('/portaria/listar/SaidasVeciulo/{id}', [PortariaTotalController::class, 'ListarTodasSaidasVeiculo']);
                Route::get('/portaria/listar/TodasEntradasSaidasVeiculo/{id}', [PortariaTotalController::class, 'ListarTodasEntradas_SaidasVeiculo']);

                Route::get('/portaria/editar/{id}', [portariaController::class, 'editarPortaria']);
                Route::get('/portaria/checklist/{id}', [portariaController::class, 'checklistPortaria']);
                Route::get('/portaria/imprimir/{id}', [portariaController::class, 'relatorioPortaria']);
                Route::post('/portaria/actualizar/{id}', [portariaController::class, 'ActualizarPortaria']);
                Route::post('portaria/pesquisar', [portariaController::class, 'pesquisar']);
                Route::get('portaria/pesquisar', [portariaController::class, 'pesquisar']);
                // Route::post('portaria/listar/pesquisar/supervisor', [portariaController::class,'pesquisar_Registros_Do_Supervisor']);
                //Portaria Imagens
                Route::get('/portaria/imagens/{id}', [PortariaImagemController::class, 'verImagens']);
                Route::post('/portaria/imagens/adicionar/{id}', [PortariaImagemController::class, 'AdcionarImagens']);
                Route::get('/portaria/imagens/editar/{id}', [PortariaImagemController::class, 'verImagem']);
                Route::get('/portaria/imagens/baixar/{id}', [PortariaImagemController::class, 'BaixarImagem']);
                Route::get('/portaria/imagens/deletar/{id}', [PortariaImagemController::class, 'DeletarImagem']);
                Route::put('/portaria/imagens/editar/actualizar/{id}', [PortariaImagemController::class, 'ActulizarImagem']);
        });

               //ordem de serviço ( OS )
        Route::middleware('can:view,App\Models\Portaria')->group(function () {
                Route::get('/os/listar', [OrdemServicoController::class, 'listar']);
                Route::get('/os/criar', [OrdemServicoController::class, 'criar']);
                Route::post('/os/add/servico', [OrdemServicoController::class, 'store']);
                Route::post('/os/imagens/adicionar/{id}', [OrdemSericoImagemController::class, 'AdcionarImagens']);
                Route::get('/os/imprimir/{id}', [OrdemServicoController::class, 'relatorioOS']);
                Route::get('/os/imagens/{id}', [OrdemSericoImagemController::class, 'verImagens']);
                Route::get('/os/imagens/baixar/{id}', [OrdemSericoImagemController::class, 'BaixarImagem']);
                Route::get('/os/imagens/deletar/{id}', [OrdemSericoImagemController::class, 'DeletarImagem']);
                Route::get('/os/imagens/editar/{id}', [OrdemSericoImagemController::class, 'verImagem']);
                Route::put('/os/imagens/editar/actualizar/{id}', [OrdemSericoImagemController::class, 'ActulizarImagem']);
                Route::get('/os/checklist/{id}',[OrdemServicoController::class,'OrdemServicochecklist']);
                Route::get('/os/editar/{id}', [OrdemServicoController::class, 'editarOS']);
                Route::post('/os/actualizar/{id}', [OrdemServicoController::class, 'ActualizarOS']);
                Route::post('/os/pesquisar', [OrdemServicoController::class,'pesquisar']);
                Route::get('/os/pesquisar', [OrdemServicoController::class,'pesquisar']);
                /************************ Manutençao preventiva *************************/
                Route::get('/manutencao/preventiva',[ManutencaoController::class,'criar']);
                Route::post('/manutencao/preventiva/add',[ManutencaoController::class,'store']);
                Route::get('/manutencao/preventiva/listar',[ManutencaoController::class,'listar']);
                Route::get('/manutencao/preventiva/checklist/{id}',[ManutencaoController::class,'manutencaochecklist']);
                Route::get('/manutencao/imprimir/{id}',[ManutencaoController::class,'relatorio']);
                //rotas para imagens
                Route::get('/manutencao/preventiva/imagens/{id}', [ManuPrentivaImagemController::class,'verImagens']);
                Route::post('/manutencao/preventiva/imagens/adicionar/{id}', [ManuPrentivaImagemController::class,'AdcionarImagens']);
                Route::get('/manutencao/preventiva/imagens/deletar/{id}',[ManuPrentivaImagemController::class,'DeletarImage']);
         });

});
