

/// codigo para o o formulario editar
if (document.querySelector('.formulario')) {

    const Formulario = document.querySelector('.formulario');

    Formulario.addEventListener('submit', async (evento) => {
        const botaoEnvioPortaria = document.querySelector('.botaoformulario').disabled = true;
    })

}

//// modal incluir serviço na orderm de serviço
function mostrar_incluir_servico2() {
    let elemento = document.querySelector('#formulario-actualizar');
    let minhaModal = new bootstrap.Modal(elemento);
    minhaModal.show();
}

function fecharModal() {
    const meuModal = new bootstrap.Modal(document.getElementById('#formulario-actualizar'));
    meuModal.hide();
}
// seleçao de elementos
const AlertaMensagem = document.querySelector("#AlertaMensagem")
const corpo_tabela = document.querySelector("#corpo_tabela")
const nome_servico = document.querySelector("#nome_servico")
const descricao_servico = document.querySelector("#descricao")
const listaPost = document.querySelector(".listaPost")



const $servicos_requesitados = {

    servicos: [{ id: 1, nome: '', descricao: '' }]

}

// Para exibir a mensagem "Nenhum serviço adicionado" usando o alert do Bootstrap
//, você pode usar o seguinte código JavaScript:

if (document.querySelector('#corpo_tabela')) {
    const tableBody = document.querySelector('#corpo_tabela');

    if (tableBody.children.length === 0) {
        const noDataAlert = document.createElement('td');
        noDataAlert.classList.add('alert', 'alert-danger', 'text-center', 'mt-3', 'Semservico');
        noDataAlert.setAttribute('role', 'alert');
        noDataAlert.setAttribute('colspan', '12');
        noDataAlert.textContent = 'Nenhum serviço adicionado';
        tableBody.parentNode.insertBefore(noDataAlert, tableBody.nextSibling);
    }

}
/*********************************  Metodo para salvarDados ***********************/

if (document.querySelector("#form_servico")) {

    const Formulario = document.querySelector("#form_servico")

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

}

function AdicionarServico(dados) {

    Id = $servicos_requesitados.servicos.length + 1

    $servicos_requesitados.servicos.push({
        id: Id,
        nome: dados.nome,
        descricao: dados.descricao,
        LinhaAdicionadaViaJavascript: "sim"
    });

    console.log(pegarServicos())

    /****************************pagination javascript ***********************************************************************/
    const linhasTabela = document.querySelectorAll('tr[data-id]');
    const linhasPorPagina = 5;
    let paginaAtual = 1;
    const DivPagination = document.querySelector("#botoes")

    if (linhasTabela.length > linhasPorPagina) {
        //Adiciona a classe 'd-block' somente se o número de linhas for maior que 5
        DivPagination.classList.remove("d-none");
        DivPagination.classList.add("d-block");
    }

    // Função para exibir as linhas da tabela correspondentes à página atual
    function mostrarLinhasDaPagina() {

        const primeiraLinha = (paginaAtual - 1) * linhasPorPagina;
        const ultimaLinha = primeiraLinha + linhasPorPagina - 1;

        linhasTabela.forEach((linha, indice) => {
            if (indice >= primeiraLinha && indice <= ultimaLinha) {
                linha.style.display = 'table-row';
            } else {
                linha.style.display = 'none';
            }
        });
    }

    // Ouvinte de eventos para os botões da página
    const botoesPagina = document.querySelectorAll('.page-link');

    botoesPagina.forEach((botao) => {
        botao.addEventListener('click', (evento) => {
            evento.preventDefault();

            if (botao.innerText === 'Anterior') {
                if (paginaAtual > 1) {
                    paginaAtual--;
                }
            } else if (botao.innerText === 'Próximo') {
                if (paginaAtual < Math.ceil(linhasTabela.length / linhasPorPagina)) {
                    paginaAtual++;
                }
            } else {
                paginaAtual = parseInt(botao.innerText);
            }

            mostrarLinhasDaPagina();
        });
    });

    //Inicialmente, exibe as linhas da primeira página
    mostrarLinhasDaPagina();
    /****************************pagination javascript ***************************************************************/

    const tr = document.createElement("tr")
    const linhasDaTabela = document.querySelectorAll('tr[data-id]') + 1;

    //removendo a informacao Nenhum serviço adicionado
    if (linhasDaTabela.length > 0 && document.querySelector(".Semservico")) {
        divSemServico = document.querySelector(".Semservico").remove();
    }

    tr.innerHTML =
        '<tr>' +
        '<td id="celula-nome">' + dados.nome + '</td>' +
        '<td id="celula-descricao">' + dados.descricao + '</td>' +
        '<td class="col-acoes">' +
        '<div class="btn-group btn-group-sm" role="group" aria-label="Ações">' +
        '<button type="button" class="btn btn-primary editar mx-1"><i class="bi bi-pen-fill editar"></i></button>' +
        '<button type="button" class="btn btn-danger deletar mx-1"><i class="bi bi-trash deletar"></i></button>' +
        '</div>' +
        '</td>' +
        '</tr>'

    tr.setAttribute('data-id', Id);
    //adicionando linhas na tabela
    corpo_tabela.appendChild(tr)
}

const saveDados = (nome, descricao) => {

    AdicionarServico({ nome: nome, descricao: descricao })
    //apagando os valores do input
    nome_servico.value = ""
    descricao_servico.value = ""
    nome_servico.focus()

}

/******** Metodo para Deletar  ******************/
function EliminarLinhaNoArray(id) {

    const listaActulizada = pegarServicos().filter((dados) => {
        return dados.id !== Number(id)
    })

    $servicos_requesitados.servicos = listaActulizada;

}

document.addEventListener('click', (evento) => {

    //recuperando o elemento clicado pelo usuario
    const elementosClicado = evento.target

    if (elementosClicado.classList.contains('deletar')) {
        //recuperado o elemento pai mas proximo com a tag tr
        const ElementoPAi = elementosClicado.closest('tr');
        const id_elemento = ElementoPAi.getAttribute('data-id')
        EliminarLinhaNoArray(id_elemento);
        ElementoPAi.remove()
    }

    if (elementosClicado.classList.contains('celula_descricao')) {

        const minhasCelulas = document.querySelectorAll('td');

        let bloqueioAtualizacao = false;

        if (!bloqueioAtualizacao) {

            function lidarEventoComBlur(evento) {
                const valorCelula = evento.target.innerText;
                const elementoClicado = evento.target;
                const elementoPai = elementoClicado.closest('tr');
                const idElemento = elementoPai.getAttribute('data-id');
                updateContentPost(idElemento, valorCelula);
                bloqueioAtualizacao = false;
            }
        }

        minhasCelulas.forEach((celula) => {
            celula.addEventListener('blur', lidarEventoComBlur);
        });

    }

    // este bloco sera exexutado quando o usuario clicar no botao editar
    if (elementosClicado.classList.contains('editar')) {

        console.log(elementosClicado);

        const linhasTabela = document.querySelectorAll('tr[data-id]');

        let idLinhaSelecionada;

        ///metodos para pegar os dados e inseir no modal
        linhasTabela.forEach((linha) => {

            const botaoEditar = linha.querySelector('.editar');

            botaoEditar.addEventListener('click', (evento) => {

                idLinhaSelecionada = linha.getAttribute('data-id');

                const descricao = linha.querySelector('#celula-descricao').innerText;
                const nome = linha.querySelector('#celula-nome').innerText;

                const formularioModal = document.querySelector('#formulario-actualizar');

                formularioModal.querySelector('#descricao').value = descricao;
                formularioModal.querySelector('#nome').value = nome;

                const botaoFechar = formularioModal.querySelector('#fechar');
                botaoFechar.addEventListener('click', () => {
                    document.querySelector('.modal-backdrop').remove();
                })

                mostrar_incluir_servico2()

            });
        });

        const formularioModal = document.querySelector('#formulario-actualizar');

        // metodos para actualizar os dados
        formularioModal.addEventListener('submit', (evento) => {

            evento.preventDefault();

            //pegando os valores da caixa de texto
            const descricao = formularioModal.querySelector('#descricao').value;
            const nome = formularioModal.querySelector('#nome').value;

            const linhaTabela = document.querySelector(`tr[data-id="${idLinhaSelecionada}"]`);

            const nomeConteudo = linhaTabela.querySelector('#celula-nome').innerText = nome;
            const descricaoConteudo = linhaTabela.querySelector('#celula-descricao').innerText = descricao;

            updateContentServico(idLinhaSelecionada, nomeConteudo, descricaoConteudo)

        });

    }
})

function pegarServicos() {
    return $servicos_requesitados.servicos;
}
// update
function updateContentServico(id, nomeConteudo, descricaoConteudo) {
    // Encontrado o array antes de actualizar
    const ServicosActulizados = pegarServicos().find((servicos) => {
        return servicos.id === Number(id)
    })

    ServicosActulizados.nome = nomeConteudo;
    ServicosActulizados.descricao = descricaoConteudo;
}

/**** submetendo os dados **********/

if (document.querySelector("#FormularioOrdemServico")) {

    const FormularioOrdemServico = document.querySelector("#FormularioOrdemServico")

    FormularioOrdemServico.setAttribute('enctype', 'multipart/form-data');

    var headers = {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    }

    FormularioOrdemServico.addEventListener('submit', async (evento) => {

        evento.preventDefault();

        const botaoEnvio = document.querySelector('#salvarOrdemServico');
        // desativando o botao de envio
        botaoEnvio.disabled = true;

        const dadosForm = new FormData(FormularioOrdemServico);

        const imagens = document.getElementById("imagens").files;
        //enviado as imagens
        if (imagens.length > 0) {

            for (let i = 0; i < imagens.length; i++) {
                dadosForm.append("imagens[]", imagens[i]);
            }
        }
        dadosForm.append("servicos", JSON.stringify($servicos_requesitados.servicos));
        //Fazendo a requisição
        const dados = await fetch("/os/add/servico", {
            method: "POST",
            body: dadosForm,
            headers: headers
        })

        const resposta = await dados.json();

        if (resposta['errors']) {

            //activando o botao de envio
            botaoEnvio.disabled = false;

            var errorMessages = document.getElementById('error-messages');
            errorMessages.style.display = 'block';
            errorMessages.innerHTML = '';
            for (var key in resposta.errors) {
                var errorMessage = document.createElement('li');
                errorMessage.innerHTML = resposta.errors[key];
                errorMessages.appendChild(errorMessage);
            }
        } else {
            if (resposta['success']) {
                sessionStorage.setItem('msg', 'Cadastro realizado com sucesso');
                window.location.href = "/os/listar";
            }
        }

    })

}
/***  Metodo para actulizar  */

if (document.querySelector("#FormularioOrdemServicoEditar")) {

    document.addEventListener('DOMContentLoaded', async () => {
        // ...
        if (Requesitados_servicos) {

            // console.log(Requesitados_servicos);
            Requesitados_servicos.forEach((valor) => {

                $servicos_requesitados.servicos.push({
                    id: valor.id_servico,
                    nome: valor.nome_servico,
                    descricao: valor.descricao,
                });
            })

        }
    });

    const FormularioOrdemServicoEditar = document.querySelector("#FormularioOrdemServicoEditar")

    FormularioOrdemServicoEditar.addEventListener('submit', async (evento) => {


        evento.preventDefault();

        const url = window.location.pathname;
        const id = url.substring(url.lastIndexOf('/') + 1);
        const Idurl = !isNaN(id) ? Number(id) : null;

        const botaoEnvio = document.querySelector('#salvarOrdemServico');
        // desativando o botao de envio
        botaoEnvio.disabled = true;

        const dadosForm = new FormData(FormularioOrdemServicoEditar);

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }

        dadosForm.append("servicos", JSON.stringify(pegarServicos()));
        //Fazendo a requisição
        const dados = await fetch("/os/actualizar/" + Idurl, {
            method: "POST",
            body: dadosForm,
            headers: headers
        })

        const resposta = await dados.json();

        if (resposta['errors']) {

            //activando o botao de envio
            botaoEnvio.disabled = false;

            var errorMessages = document.getElementById('error-messages');
            errorMessages.style.display = 'block';
            errorMessages.innerHTML = '';
            for (var key in resposta.errors) {
                var errorMessage = document.createElement('li');
                errorMessage.innerHTML = resposta.errors[key];
                errorMessages.appendChild(errorMessage);
            }
        } else {
            if (resposta['success']) {
                sessionStorage.setItem('msg', 'Dados actualizado com sucesso');
                window.location.href = "/os/listar";
            }
        }

    })

}

/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/
/********** Formularioa Manutenção preventiva ********************************/

if (document.querySelector("#FormularioOrdemServicoEditar")) {

    const FormularioManutencaoPreventiva = document.querySelector("#FormularioManutencaoPreventiva")

    FormularioManutencaoPreventiva.addEventListener('submit', async (evento) => {

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }

        evento.preventDefault();

        const botaoEnvio = document.querySelector('#SalvarManutencaoPreventiva');
        // desativando o botao de envio
        botaoEnvio.disabled = true;

        const dadosForm = new FormData(FormularioManutencaoPreventiva);

        const imagens = document.getElementById("imagens").files;
        //enviado as imagens
        if (imagens.length > 0) {

            for (let i = 0; i < imagens.length; i++) {
                dadosForm.append("imagens[]", imagens[i]);
            }
        }
        dadosForm.append("servicos", JSON.stringify($servicos_requesitados.servicos));
        //Fazendo a requisição
        const dados = await fetch("/manutencao/preventiva/add", {
            method: "POST",
            body: dadosForm,
            headers: headers
        })

        const resposta = await dados.json();

        if (resposta['errors']) {

            //activando o botao de envio
            botaoEnvio.disabled = false;

            var errorMessages = document.getElementById('error-messages');
            errorMessages.style.display = 'block';
            errorMessages.innerHTML = '';
            for (var key in resposta.errors) {
                var errorMessage = document.createElement('li');
                errorMessage.innerHTML = resposta.errors[key];
                errorMessages.appendChild(errorMessage);
            }
        } else {
            if (resposta['success']) {
                sessionStorage.setItem('msg', 'Cadastro realizado com sucesso');
                window.location.href = "/manutencao/preventiva/listar";
            }
        }

    })

    /*
    // remover a mensagem após exibir os dados 
    window.addEventListener('load', function () {
        //(a removendo a sessao)
        sessionStorage.removeItem('msg');
    });
    */

    /******************************************************************************/

    const FormularioManutencaoPreventivaEditar = document.querySelector("#FormularioManutencaoPreventivaEditar")

    FormularioManutencaoPreventivaEditar.addEventListener('submit', async (evento) => {

        evento.preventDefault();

        //recuperado o id da url
        const url = window.location.pathname;
        const id = url.substring(url.lastIndexOf('/') + 1);
        const Idurl = !isNaN(id) ? Number(id) : null;

        const botaoEnvio = document.querySelector('#ActualizarManutencaoPreventiva');
        // desativando o botao de envio
        botaoEnvio.disabled = true;

        const dadosForm = new FormData(FormularioManutencaoPreventivaEditar);

        var headers = {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }

        dadosForm.append("servicos", JSON.stringify(pegarServicos()));
        //Fazendo a requisição
        const dados = await fetch("/manutencao/preventiva/actualizar/" + Idurl, {
            method: "POST",
            body: dadosForm,
            headers: headers
        })

        const resposta = await dados.json();

        if (resposta['errors']) {

            //activando o botao de envio
            botaoEnvio.disabled = false;

            var errorMessages = document.getElementById('error-messages');
            errorMessages.style.display = 'block';
            errorMessages.innerHTML = '';
            for (var key in resposta.errors) {
                var errorMessage = document.createElement('li');
                errorMessage.innerHTML = resposta.errors[key];
                errorMessages.appendChild(errorMessage);
            }
        } else {
            if (resposta['success']) {
                sessionStorage.setItem('msg', 'Dados actualizado com sucesso');
                window.location.href = "/os/listar";
            }
        }

    })

}


