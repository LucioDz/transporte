
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
});

//// modal incluir serviço na orderm de serviço
function mostrar_incluir_servico2() {
    let elemento = document.querySelector('#exampleModal2');
    let minhaModal = new bootstrap.Modal(elemento);
    minhaModal.show();
}

// seleçao de elementos
const Formulario = document.querySelector("#form_servico")
const AlertaMensagem = document.querySelector("#AlertaMensagem")
const corpo_tabela = document.querySelector("#corpo_tabela")
const nome_servico = document.querySelector("#nome_servico")
const descricao_servico = document.querySelector("#descricao")

let old_nome_servico;
let old_descricao_servico;

// metodo para salvarDados

Formulario.addEventListener('submit',(evento) => {

    evento.preventDefault();
    //corpo_tabela.innerHTML = $dados
    // pegando os valores do input
    const nome = nome_servico.value
    const desc  = descricao_servico.value
   
    if(nome ) {
    //metodo de salvardados
      saveDados(nome,desc);
    }

})

const  saveDados = (nome,descricao) => {
    
    const tr = document.createElement("tr")
    // adicionando linhas na tabela
      tr.innerHTML = 
      '<tr>'+
      '<td>'+nome+'</td>'+
      '<td>'+descricao+'</td>'+
      '<td><buttton class="btn btn-danger deletar"><i class="bi bi-trash" class="deletar"></i></button></td>'+
      '<td><button class="btn btn-primary editar" class="editar"><i class="bi bi-pen-fill"></i></button></td>'+
      '</tr>'

     corpo_tabela.appendChild(tr)

      //apagando os valores do input
      nome_servico.value = ""
      descricao_servico.value = ""
      nome_servico.focus()
    
}

// evento click para todo o documento
document.addEventListener('click' ,(evento) => {

    let linha;

    //recuperando o elemento clicado pelo usuario
    const elementosClicado = evento.target

    //recuperado o elemento pai mas proximo com a tag tr
    const ElementoPAi = elementosClicado.closest('tr');

    // eliminando a linha da tabela selecionada
    if(elementosClicado.classList.contains('deletar')){ 
         ElementoPAi.remove();
    }
    
    if(elementosClicado.classList.contains('editar')){ 
        //chamar metodo do arquivo meuscript.js
         mostrar_incluir_servico2()

         nome_servico.value = linha;
         old_nome_servico = linha;
    }

    if(ElementoPAi && ElementoPAi.querySelector('tr')){
        linha =  ElementoPAi.querySelector('tr').innerText;  
    }

})


/*
var headers = {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
}

Formulario.addEventListener('submit', async (evento) => {

    evento.preventDefault();
    //console.log("cadastrar");
    const dadosForm = new FormData(Formulario);
    dadosForm.append("add",1);
    
    //Fazendo a requisição
    const dados = await fetch("/os/add/servico",{
        method:"POST",
        body:dadosForm,
        headers: headers
    })

    const resposta = await dados.json();

    if(resposta['erro']){
        
        AlertaMensagem.innerHTML = resposta['msg'];
        corpo_tabela.innerHTML  = resposta['tabela']

    }else{
        AlertaMensagem.innerHTML = resposta['msg'];
    }

})
*/

/*
    var xhr = new XMLHttpRequest();
    var dados;

     /// tipo resposta no formato json
    xhr.responseType = "json";
    /// analisando o estado da requisão
    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
           
            dados = xhr.response;
            console.log(dados)
        }
        else if (xhr.status == 404) {
            alert('URL não econtrada');
        }
    }
    xhr.open('GET','/os/add/servico')
    xhr.send();
*/

/*
var xhr = new XMLHttpRequest;
xhr.responseType = "json";
var documento =  {
      "nome_servico": 'jacinto', 
      "descricao_os": 'Angola',
      "body":"corpo"
 }
xhr.onreadystatechange = function() {

    if (xhr.readyState == 4 && xhr.status == 200) {
        console.log(xhr.response)
    } else if (xhr.status == 404) {
        alert('URL não econtrada');
    }
}
xhr.open('GET','/os/add/servico/2')
xhr.send(documento);
*/
/*
const listardados = async () => {
    const dados = await fetch("/os/add/servico/")
    const resposta = await dados.text();
    console.log(resposta)
}

listardados();
*/