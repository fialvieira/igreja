function detalhesPedido(compra_id) {
    try {
        let strpar = query_string({
            'compra_id': compra_id
        });
        ajax('detalhes.php', strpar, function (html) {
            try {
                document.getElementById('detalhes_grid').innerHTML = html;
                modal.abre('j_detalhes');
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function aprova(campo, tipo, id) {
    try {
        let strpar = '';
        if (tipo == 'R') {
            modal.abre('j_observacao', function () {
                if (obs != '') {
                    strpar = query_string({
                        'aprova': tipo,
                        'id': id,
                        'observacao': obs
                    });
                    ajax('aprova.php', strpar, function (json) {
                        try {
                            let r = JSON.parse(json);
                            if (r.erro) {
                                throw r.mensagem;
                            }
                            obs = '';
                            mudaClasse(campo, tipo);
                        } catch (e) {
                            alerta.erro(e, 5);
                        }
                    });
                }
            });
        } else {
            strpar = query_string({
                'aprova': tipo,
                'id': id,
                'observacao': ''
            });
            ajax('aprova.php', strpar, function (json) {
                try {
                    let r = JSON.parse(json);
                    if (r.erro) {
                        throw r.mensagem;
                    }
                    mudaClasse(campo, tipo);
                } catch (e) {
                    alerta.erro(e, 5);
                }
            });
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function mudaClasse(a, tipo) {
    let div = a.parentNode;
    let a_remover = div.querySelector((tipo == 'P') ? '.negativo' : '.positivo');
    a_remover.style.display = 'none';
    a.removeAttribute('onclick');
    let classe = (tipo == 'P') ? 'positivo_des' : 'negativo_des';
    a.classList.remove((classe == 'positivo_des') ? 'positivo' : 'negativo');
    a.classList.add(classe);
    a.setAttribute('title', (classe == 'positivo_des') ? 'Aprovado' : 'Recusado');
}

function salvaObservacao(id) {
    try {
        let campo = document.getElementById(id);
        let div_campo = campo.parentNode.parentNode;
        if (campo.value == '' || String(campo.value).length < 4) {
            div_campo.classList.add('nao-preenchido');
            throw 'O campo não pode estar vazio';
        } else {
            if (div_campo.classList.contains('nao-preenchido')) {
                div_campo.classList.remove('nao-preenchido');
            }
            obs = campo.value;
            modal.fecha();
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function montaParametros(campos) {
    function query_string_elementos(elementos) {
        let dic = {};
        for (let i = 0; i < elementos.length; i++) {
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

    let params = query_string_elementos(campos.querySelectorAll('input, select, textarea'));
    return params;
}

function pesquisa() {
    try {
        let grid = document.querySelector(".container-grid .grid");

        function retorno(html) {
            grid.innerHTML = html;
            let tr = grid.querySelectorAll("table tbody tr");
            if (tr.length == 0) {
                grid.innerHTML = "";
            }
            document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
            let hash = historico.hash();
            hash.data_inicial = document.getElementById("data_inicial").value;
            hash.data_final = document.getElementById("data_final").value;
            hash.situacao = document.getElementById("situacao").value;
            hash.solicitante = (document.getElementById("solicitante").dataset.id) ? document.getElementById("solicitante").dataset.id : '';
            hash.nome = document.getElementById("solicitante").value;
            historico.push(hash);
        }

        formulario.valida(f);
        let strpar = montaParametros(f);
        ajax("pesquisa.php", strpar, retorno);
        grid.innerHTML = templates.CARREGANDO;
        document.getElementById("total_registros").innerHTML = "";
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function limpa() {
    var inputs = document.querySelectorAll('input');
    var selects = document.querySelectorAll('select');
    var txarea = document.querySelectorAll('textarea');
    var table = document.getElementById('tbl_solicitantes');
    document.getElementById('total_registros').innerText = '';
    if (table) {
        table.innerHTML = '';
    }

    if (inputs != null && inputs.length != 0) {
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }
    }
    if (selects != null && selects.length != 0) {
        for (var i = 0; i < selects.length; i++) {
            selects[i].value = ''; //-1
        }
    }
    if (txarea != null && txarea.length != 0) {
        for (var i = 0; i < txarea.length; i++) {
            txarea[i].value = '';
        }
    }
    var hash = historico.hash();
    if (hash.data_inicial || hash.data_final || hash.situacao || hash.solicitante) {
        delete hash.data_inicial;
        delete hash.data_final;
        delete hash.situacao;
        delete hash.solicitante;
        historico.push(hash);
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

historico.load(function (hash) {
    if (hash.data_inicial || hash.data_final || hash.situacao || hash.solicitante) {
        document.getElementById('data_inicial').value = hash.data_inicial;
        document.getElementById("data_final").value = hash.data_final;
        document.getElementById("situacao").value = hash.situacao;
        document.getElementById("solicitante").value = hash.nome;
        document.getElementById("solicitante").dataset.id = hash.solicitante;
        pesquisa();
    }
});
let f = document.getElementById('qbe');
let obs = '';
let evento = new Event("keyup");
evento.keyCode = 13;
combo.registra(document.getElementById('solicitante'), document.getElementById('j_solicitante'), filtraCombo, selecionaCombo, null);