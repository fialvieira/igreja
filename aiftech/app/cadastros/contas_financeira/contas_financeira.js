function filtraCombo(e, campo, janela) {
    var t = janela.querySelector("table tbody");
    full_text(e, t, campo, 1);
}

function selecionaCombo(linha) {
    document.getElementById(linha.dataset.campo).value = linha.dataset.nome;
    document.getElementById(linha.dataset.campo).dataset.id = linha.dataset.id;
}

function montaParametros(campos) {
    function query_string_elementos(elementos) {
        var dic = {};
        for (var i = 0; i < elementos.length; i++) {
            if (elementos[i].type != 'checkbox' && elementos[i].type != 'radio' || elementos[i].checked) {
                if (elementos[i].dataset.id) {
                    dic[elementos[i].name || elementos[i].id] = elementos[i].dataset.id;
                } else {
                    dic[elementos[i].name || elementos[i].id] = elementos[i].value;
                }
            }
        }
        return query_string(dic);
    }

    var params = query_string_elementos(campos.querySelectorAll('input, select, textarea'));
    return params;
}

function salva() {
    try {
        formulario.valida(f);
        var strpar = montaParametros(f);
        ajax("salva.php", strpar, function (resp) {
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

function voltar() {
    window.history.back();
}

var f = document.querySelector(".campos");

combo.registra(document.getElementById('banco_id'), document.getElementById('j_bancos'), filtraCombo, selecionaCombo, null);