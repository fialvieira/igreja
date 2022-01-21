function salva() {
    try {
        document.getElementById('salvar').classList.add('oculto');
        
        formulario.valida(f);
        ajax("salva.php", f, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                setTimeout(function () {
                    voltar();
                }, 1000);
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
        document.getElementById('salvar').classList.remove('oculto');
    }
}

function voltar() {
    window.history.back();
}

var f = document.querySelector(".campos");