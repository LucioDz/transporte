//a linha serve para carregar o pluguin seltect2
$(document).ready(function () {
    $('#select_motoristas').select2();
    $('#select_veiculos').select2();
    $('#select_cobrador').select2();
    $('#select_tipo').select2();
    $('#usuairosPesquisar').select2();
    $('#nada1').select2();
    $('#nada2').select2();
    $('#nada3').select2();
    $('#portaria2').select2();
    $('#base').select2();
    $('#base').select2();
    $('#situacao_os').select2();
    $('#select_tipo_os').select2();
});


/// Meotods para previsualizar a imagem 
function previsualizarImagem() {

    var camainho = document.querySelector('input[name=foto_de_perfil]').files[0];
    var imagem = document.querySelector('img#photo_ferfil');

    //fileRerder perminte ler o conteodo do arquivo de forma assicrona
    var LerImagem = new FileReader();
    //evento ondolead - chamavdo sempre for finalizada a leitura do arquivo pelo FileReader
    LerImagem.onloadend = function () {
        //atriubuindo o resultado da leitura do arquivo ao src da imagem
        imagem.src = LerImagem.result;
    }
    //verificando se exite o caminho
    if (camainho) {
        // retornado o caminho da imagem
        LerImagem.readAsDataURL(camainho)
    } else {
        //setar este caminho caso nao encontre caminho da imagem
        imagem.src = "/img/perfilsemfoto.jpg"
    }

}
function RemoverImagemPrevisualizada() {

    var imagem = document.querySelector('img#photo_ferfil');
    imagem.src = "/img/perfilsemfoto.jpg"
}

function mostrar_cadastrar() {
    let elemento = document.querySelector('#exampleModalCenter');
    let minhaModal = new bootstrap.Modal(elemento);
    minhaModal.show();
}

function mostrar_actulizar() {
    let elemento = document.querySelector('#mostrar_actulizar');
    let minhaModal = new bootstrap.Modal(elemento);
    minhaModal.show();
}

function mostrar_usuario() {
    let elemento = document.querySelector('#mostrar_actulizar');
    let minhaModal = new bootstrap.Modal(elemento);
    minhaModal.show();
}
//// modal incluir serviço na orderm de serviço
function mostrar_incluir_servico() {
    let elemento = document.querySelector('#exampleModal');
    let minhaModal = new bootstrap.Modal(elemento);
    minhaModal.show();
}

function calcular_lotacao() {

    var Lugares_em_pe = document.querySelector("#em_pe").value
    var Lugares_sentados = document.querySelector("#lugares_sentados").value
    var lotacao = document.querySelector("#lotacao");

    if ((Lugares_em_pe == "")) {
        alert('Preenha o campo Lugares em pe');
    } else if (Lugares_sentados == "") {
        alert('Preenha o campo Lugares sentados');
    } else if (isNaN(Number(Lugares_sentados))) {
        alert('Valor do campo Lugares Sentados invalido');
    }
    else if (isNaN(Number(Lugares_em_pe))) {
        alert('Valor do campo Lugares Em pe invalido');
    }
    else {
        valor1 = parseInt(Lugares_em_pe);
        valor2 = parseInt(Lugares_sentados);
        lotacao.value = valor1 + valor2
    }
}

// funcao para fazer aprecer uma coluna em inserir base 
function provicnia() {
    var element = document.getElementById("coluna");
    element.classList.toggle("d-none");
}

function removerprovincia() {
    var element = document.getElementById("coluna");
    element.classList.add("d-none");
}














