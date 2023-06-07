/********** Formularioa Manutenção preventiva ********************************/

if (document.querySelector("#FormularioManutencaoPreventiva")) {

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

}

if (document.querySelector("#FormularioManutencaoPreventivaEditar")) {

  
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
                window.location.href = "/manutencao/preventiva/listar";
            }
        }

    })

}


