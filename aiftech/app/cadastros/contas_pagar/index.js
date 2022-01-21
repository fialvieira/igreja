function mostra_arquivos(id) {
    const strpar = query_string({
        'compra_id': id
    });
    ajax('arquivos.php', strpar, function (html) {
        if (html) {
            document.getElementById('detalhes_grid').innerHTML = html;
            const hash = historico.hash();
            hash.arquivos = '1';
            historico.push(hash);
            modal.abre('j_arquivos', function () {
                const hash = historico.hash();
                delete hash.arquivos;
                historico.push(hash);
            });
        } else {
            alerta.info('Esta Solicitação não possui orçamentos anexos.', 3);
        }
    });
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

function cadastraPagamento(compras_id) {
    try {

    } catch (e) {
        alerta.erro(e, 5);
    }
}

historico.load(function (hash) {
    if (hash.data_inicial || hash.data_final || hash.situacao || hash.solicitante) {
        document.getElementById('data_inicial').value = hash.data_inicial;
        document.getElementById("data_final").value = hash.data_final;
        document.getElementById("solicitante").value = hash.nome;
        document.getElementById("solicitante").dataset.id = hash.solicitante;
        pesquisa();
    } else {
        pesquisa();
    }
});
let f = document.getElementById('qbe');
let obs = '';
let evento = new Event("keyup");
evento.keyCode = 13;
combo.registra(document.getElementById('solicitante'), document.getElementById('j_solicitante'), filtraCombo, selecionaCombo, null);