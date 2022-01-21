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

function montaParametros(campos) {
    gravaFornecedores();
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
    params += '&fornecedores=' + fornecedores;
    return params;
}

function gravaFornecedores() {
    var a_dons = document.getElementById('ctn_fornecedor').querySelectorAll('a');
    for (var i = 0; i < a_dons.length; i++) {
        fornecedores[i] = a_dons[i].getAttribute('data-id');
    }
}

function valida(id, ctn) {
    var a_ig = ctn.querySelectorAll('a');
    var ret = true;
    for (var i = 0; i < a_ig.length; i++) {
        if (parseInt(id) === parseInt(a_ig[i].getAttribute('data-id'))) {
            ret = false;
        }
    }
    return ret;
}

function remover(campo) {
    var node = campo.parentNode;
    var p = node.parentNode;
    if (p) {
        p.removeChild(node);
    }
}

function adicionaLinha(campo, ctn) {
    var v_campo = campo.value;
    var t_campo = '';
    if (v_campo != '') {
        t_campo = campo.options[campo.selectedIndex].text;
    }
    if (valida(v_campo, document.getElementById(ctn))) {
        var a_ctn = ctn.replace('ctn', 'a');
        document.getElementById(ctn).insertAdjacentHTML('beforeend',
            '<div class="' + a_ctn + '">' +
            '  <a class="acao excluir" onclick="remover(this)" data-id="' + v_campo + '"></a>' +
            '  <label>' + t_campo + '</label>' +
            '</div>');
    }
}

var f = document.querySelector(".campos");
var fornecedores = new Array();