function salva() {
    try {
        formulario.valida(f);
        ajax("salva.php", f, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                voltar();
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function validaNumero(campo) {
    try {
        var strpar = query_string({
            'numero': campo.value
        });
        ajax('valida_numero.php', strpar, function (json) {
            try {
                var r = JSON.parse(json);
                var mensagem = campo.parentNode.querySelector('.mensagem');
                if (!r.valido) {
                    throw r.mensagem;
                } else {
                    if(campo.parentNode.parentNode.classList.contains('erro')){
                        campo.parentNode.parentNode.classList.remove('erro');
                        mensagem.innerText = '';
                    }
                }
            } catch (e) {
                mensagem.innerText = e;
                campo.parentNode.parentNode.classList.add('erro');
            }
        })
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function voltar() {
    window.history.back();
}

var f = document.querySelector(".campos");