
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
const listaPost = document.querySelector(".listaPost")

// metodo para salvarDados

const saveDados = (nome, descricao) => {

  const tr = document.createElement("tr")

    //adicionando linhas na tabela
    tr.innerHTML =
        '<tr>' +
        '<td>' + nome + '</td>' +
        '<td>' + descricao + '</td>' +
        '<td><button class="btn btn-danger deletar"><i class="bi bi-trash" class="deletar"></i></button></td>' +
        '<td><button class="btn btn-primary editar" class="editar"><i class="bi bi-pen-fill"></i></button></td>' +
        '</tr>'

    corpo_tabela.appendChild(tr)

    criarPost({ owner: nome, content: descricao })

    //apagando os valores do input
    nome_servico.value = ""
    descricao_servico.value = ""
    nome_servico.focus()

}

//Deletando 
document.querySelector('.listaPost').addEventListener('click', (evento) => {
    console.log('deletar', evento.target)

    const elementoAcutal = evento.target;
    const isBtnDelete = evento.target.classList.contains('btn-delete')

    if (isBtnDelete) {
        const id_elemento = elementoAcutal.parentNode.getAttribute('data-id')
        console.log('deletar')
        elementoAcutal.parentNode.remove();
        apagaPost(id_elemento)

    }
})

/// update 
document.querySelector('.listaPost').addEventListener('input', (evento) => {

    // console.log(pegarPosts())
    const elementoAcutal = evento.target;
    const id_elemento = elementoAcutal.parentNode.getAttribute('data-id')
    updateContentPost(id_elemento,elementoAcutal.innerText)

})

Formulario.addEventListener('submit', (evento) => {

    evento.preventDefault();
    //corpo_tabela.innerHTML = $dados
    // pegando os valores do input
    const nome = nome_servico.value
    const desc = descricao_servico.value

    if (nome) {
        //metodo de salvar dados
        saveDados(nome, desc);
    }
    /**** **********************/
})

document.addEventListener('click', (evento) => {

    //recuperando o elemento clicado pelo usuario
    const elementosClicado = evento.target

    //recuperado o elemento pai mas proximo com a tag tr
    const ElementoPAi = elementosClicado.closest('tr');

    if (elementosClicado.classList.contains('deletar')) {
        console.log(ElementoPAi)
        ElementoPAi.remove();
    }

    if (elementosClicado.classList.contains('editar')) {
        //chamar metodo do arquivo meuscript.js
        mostrar_incluir_servico2()
    }

})

const miniTwitter = {

    usuarios: [{ username: 'lucio', }],

    post: [{ id: 1, owner: 'lucio', content: 'Meu primeiro tweet' }]

}

function criarPost(dados) {

    Id = miniTwitter.post.length + 1

    miniTwitter.post.push({
        id: Id,
        owner: dados.owner,
        content: dados.content
    });

    listaPost.insertAdjacentHTML('afterbegin',

        '<li data-id=' + Id + '>'
        + '<button class="btn-delete">Delete</button>' +
        '<span contenteditable>' + dados.owner + '</span>' +
        '</li>'
    )

}

function pegarPosts() {
    return miniTwitter.post;
}
// update
function updateContentPost(id,novoConteudo) {
    // Encontrado o array antes de actualizar
    const PostQueseraActulizado = pegarPosts().find((post) => {
        return post.id === Number(id)
    })

    PostQueseraActulizado.content = novoConteudo;

    console.log(PostQueseraActulizado)

}

function apagaPost(id) {

    const listaPostActulizada = pegarPosts().filter((post) => {
        return post.id !== Number(id)
    })

    miniTwitter.post = listaPostActulizada;

    console.log(listaPostActulizada)
}


//criarPost({owner:'junior',content:'segundo post'})

//criarPost({owner:'beto',content:'segundo post'})

//apagaPost(1)

//updateContentPost(2,'novo conteudo do post')

//console.log(pegarPosts())

/*************************************/

// console.log('ola pessoas! Nivel 2')

/// console.log('#construindoCRUDS')

