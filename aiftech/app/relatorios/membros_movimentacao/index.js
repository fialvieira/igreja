function pesquisa() {
    try {
        let strpar = montaParametros(f);
        alerta.info('Gerando relatório...', 8);
        window.open('membro.php?' + strpar, '_self');
    } catch (e) {
        alerta.erro(e, 8);
    }
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

function validaCombo(campo) {
    try {
        var pai = campo.parentNode.parentNode;
        var label = pai.querySelector("div.rotulo label").innerText;
        if (!campo.dataset.id && campo.value != '') {
            campo.value = '';
            throw 'O valor preenchido não consta em nossa base de ' + label;
        }
    } catch (e) {
        formulario.mensagemCampo(campo, e, true);
    }
}

function filtraCombo(e, campo, janela) {
    var t = janela.querySelector("table tbody");
    full_text(e, t, campo, 1);
}

function selecionaCombo(linha) {
    document.getElementById(linha.dataset.campo).value = linha.dataset.nome;
    document.getElementById(linha.dataset.campo).dataset.id = linha.dataset.id;
}

let f = document.querySelector(".qbe");

combo.registra(document.getElementById('membro'), document.getElementById('j_membros'), filtraCombo, selecionaCombo, validaCombo);