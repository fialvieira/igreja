function salva() {
    try {
        formulario.valida(f);
        if (document.getElementById('cadastro_senha').value != document.getElementById('cadastro_senha2').value) {
            throw 'Senhas não coincidem.';
        }
        ajax('salva.php', f, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                document.getElementById('codigo').value = r.id;
                alerta.sucesso('Salvo.', 2);
                setTimeout(function () {
                    voltar();
                }, 1000);
            } catch (e) {
                alerta.erro(e, 5);
            }
        }, 'POST');
        alerta.info('Salvando...');
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function troca_senha() {
    var div_senha = document.getElementById('cadastro_senha').parentNode.parentNode;
    var div_senha2 = document.getElementById('cadastro_senha2').parentNode.parentNode;
    div_senha.classList.remove('oculto');
    document.getElementById('cadastro_senha').required = true;
    div_senha2.classList.remove('oculto');
    document.getElementById('cadastro_senha2').required = true;
    if (document.getElementById('btn_troca_senha')) {
        document.getElementById('btn_troca_senha').classList.add('oculto');
    }
}

function voltar() {
    window.history.back();
}

var f = document.querySelector('.campos');

if (document.getElementById('codigo').value && !document.getElementById('senha_atual')) {
    var div_senha = document.getElementById('cadastro_senha').parentNode.parentNode;
    var div_senha2 = document.getElementById('cadastro_senha2').parentNode.parentNode;
    div_senha.classList.add('oculto');
    document.getElementById('cadastro_senha').required = false;
    div_senha2.classList.add('oculto');
    document.getElementById('cadastro_senha2').required = false;
    document.getElementById('btn_troca_senha').classList.remove('oculto');
}
