function ocultaOpcao(campo, valor) {
    try {
        campo.value = '';
        var options = campo.querySelectorAll('option');
        for (var i = 1; i < options.length; i++) {
            if (options[i].value == valor) {
                options[i].classList.add('oculto');
            }
        }
    } catch (e) {
        alerta.erro(e, 3);
    }
}

function desocultaOpcao(campo, valor) {
    try {
        campo.value = '';
        var options = campo.querySelectorAll('option');
        for (var i = 1; i < options.length; i++) {
            if (options[i].value == valor) {
                options[i].classList.remove('oculto');
            }
        }
    } catch (e) {
        alerta.erro(e, 3);
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

function adicionaLinha(campo, ctn) {
    var v_campo = campo.value;
    if (v_campo != '') {
        var t_campo = campo.options[campo.selectedIndex].text;
        if (valida(v_campo, document.getElementById(ctn))) {
            var a_ctn = ctn.replace('ctn', 'a');
            document.getElementById(ctn).insertAdjacentHTML('beforeend',
                '<div class="' + a_ctn + '">' +
                '  <a class="acao excluir" onclick="remover(this)" data-id="' + v_campo + '"></a>' +
                '  <label>' + t_campo + '</label>' +
                '</div>');
            ocultaOpcao(campo, v_campo);
        }
    }

}

function remover(campo) {
    var node = campo.parentNode;
    var p = node.parentNode;
    if (p) {
        p.removeChild(node);
        desocultaOpcao(document.getElementById('conta_bancaria'), campo.dataset.id);
    }
}

function gravaContasBancarias() {
    var a_dons = document.getElementById('ctn_conta_bancaria').querySelectorAll('a');
    for (var i = 0; i < a_dons.length; i++) {
        contas[i] = a_dons[i].getAttribute('data-id');
    }
}

function montaParametros(campos) {
    gravaContasBancarias();

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
    params += '&contas_bancarias=' + contas;
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
                } else {
                    if (r.tipo == 'A') {
                        volta();
                    } else {
                        limpaCampos();
                        carregaCategorias();
                        alerta.sucesso("Salvo.", 3);
                    }
                }
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
        alerta.info("Salvando...", 5);
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function carregaCategorias() {
    try {
        var strpar = '';
        ajax('carrega_categorias', strpar, function (html) {
            try {
                document.getElementById('categoria_mae').innerHTML = html;
            } catch (e) {
                alerta.erro(e, 3);
            }
        })
    } catch (e) {
        alerta.erro(e, 3);
    }
}

function volta() {
    window.history.back();
}

function limpaCampos() {
    formulario.limpaCampos(f);
    document.getElementById('ctn_conta_bancaria').innerHTML = '';
}

function escreveMensagem(campo) {
    try {
        var pai = campo.parentNode.parentNode;
        var msg = pai.querySelector('.mensagem');
        var cat_mae = document.getElementById('categoria_mae');
        if (cat_mae.value != '' && campo.value != '') {
            var num_mae = cat_mae.options[cat_mae.selectedIndex].text.split(' - ');
            msg.innerText = num_mae[0] + '.' + campo.value;
        }
    } catch (e) {
        alerta.erro(e, 3);
    }
}

function validaNumero(campo) {
    try {
        var pai = campo.parentNode.parentNode;
        var msg = pai.querySelector('.mensagem');
        if (campo.value) {
            campo.value = campo.value.trim();
            var er = /^\d+(\.\d+)*$/gm;
            if (!campo.value.match(er)) {
                pai.classList.add('erro');
                campo.value = '';
                throw 'Formato de número inválido.';
            } else {
                if (pai.classList.contains('erro')) {
                    pai.classList.remove('erro');
                    msg.innerText = '';
                }
            }
        } else {
            pai.classList.add('erro');
            campo.focus();
            throw 'O campo não pode estar em branco';
        }
    } catch (e) {
        msg.innerText = e;
    }
}

function ajustaNumero(campo) {
    try {
        var pai = campo.parentNode.parentNode;
        var msg = pai.querySelector('.mensagem');
        msg.innerText = '';
        validaNumero(campo);
        var cat_mae = document.getElementById('categoria_mae');
        if (cat_mae.value != '' && campo.value != '') {
            var num_mae = cat_mae.options[cat_mae.selectedIndex].text.split(' - ');
            campo.value = num_mae[0] + '.' + campo.value;
        }
        if (existeNumero(campo)) {
            var numero = campo.value;
            campo.value = '';
            campo.focus();
            throw 'O número ' + numero + ' já está cadastrado, por favor, digite outro número';
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function existeNumero(campo) {
    try {
        var existe = false;
        var opcoes_mae = document.getElementById('categoria_mae').options;
        for (var i = 1; i < opcoes_mae.length; i++) {
            var opcao = opcoes_mae[i].text.split(' - ');
            if (campo.value == opcao[0]) {
                existe = true;
                throw existe;
            }
        }
        return existe;
    } catch (e) {
        return existe;
    }
}

function ajustaTipo(campo) {
    try {
        if (document.getElementById('numero').value != '') {
            document.getElementById('numero').value = '';
        }
        if (campo.value != '') {
            var strpar = query_string({
                'id': campo.value
            });
            ajax('pega_dados.php', strpar, function (json) {
                try {
                    var r = JSON.parse(json);
                    if (r.erro) {
                        throw r.mensagem;
                    } else {
                        document.getElementById('tipo').value = r.tipo;
                        document.getElementById('tipo').disabled = true;
                    }
                } catch (e) {
                    alerta.erro(e, 5);
                }
            });
        } else {
            document.getElementById('tipo').disabled = false;
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

var f = document.querySelector(".campos");
var contas = new Array();