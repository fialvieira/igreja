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

function pesquisa() {
    try {
        const grid = document.querySelector(".container-grid .grid");
        const params = query_string({
            'solicitante': document.getElementById('solicitante').dataset.value,
            'data_inicial': document.getElementById('data_inicial').value,
            'data_final': document.getElementById('data_final').value
        });
        ajax("pesquisa.php", params, function (html) {
            grid.innerHTML = html;
            const tr = grid.querySelectorAll("table tbody tr");
            if (tr.length == 0) {
                grid.innerHTML = "";
            }
            document.getElementById("total_registros").innerHTML = `${tr.length} registros encontrados`;
            const hash = historico.hash();
            hash.data_inicial = document.getElementById("data_inicial").value;
            hash.data_final = document.getElementById("data_final").value;
            hash.solicitante = (document.getElementById("solicitante").dataset.id) ? document.getElementById("solicitante").dataset.id : '';
            hash.nome = document.getElementById("solicitante").value;
            historico.push(hash);
        });
        grid.innerHTML = templates.CARREGANDO;
        document.getElementById("total_registros").innerHTML = "";
    } catch (e) {
        alerta.erro(e, 8);
    }
}

function limpa() {
    const inputs = document.querySelectorAll('input');
    const table = document.querySelector('.grid table');
    document.getElementById('total_registros').innerText = '';
    if (table) {
        table.innerHTML = '';
    }

    if (inputs != null && inputs.length != 0) {
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }
    }

    const hash = historico.hash();
    if (hash.data_inicial || hash.data_final || hash.solicitante) {
        delete hash.data_inicial;
        delete hash.data_final;
        delete hash.solicitante;
        historico.push(hash);
    }
}

function filtraCombo(e, campo, janela) {
    const t = janela.querySelector("table tbody");
    full_text(e, t, campo, 1);
}

function selecionaCombo(linha) {
    document.getElementById('solicitante').value = linha.dataset.nome;
    document.getElementById('solicitante').dataset.value = linha.dataset.id;
}

function validaCombo(campo) {
    try {
        const pai = campo.parentNode.parentNode;
        const label = pai.querySelector("div.rotulo label").innerText;
        if (!campo.dataset.value && campo.value != '') {
            campo.value = '';
            throw 'O valor preenchido não consta em nossa base de ' + label;
        }
    } catch (e) {
        formulario.mensagemCampo(campo, e, true);
    }
}

historico.load(function (hash) {
    if (hash.data_inicial || hash.data_final || hash.solicitante) {
        document.getElementById('data_inicial').value = hash.data_inicial;
        document.getElementById("data_final").value = hash.data_final;
        document.getElementById("solicitante").value = hash.nome;
        document.getElementById("solicitante").dataset.value = hash.solicitante;
        pesquisa();
    }
    if (hash.arquivos) {
        modal.abre('j_arquivos', function () {
            const hash = historico.hash();
            delete hash.arquivos;
            historico.push(hash);
        });
    } else {
        modal.fecha();
    }
});

//function filtra(e) {
//    const hash = historico.hash();
//    const t = document.querySelector(".container-grid .grid table tbody");
//    full_text(e, t, document.getElementById("txt_pesquisa"), 3);
//    if (!document.getElementById("txt_pesquisa").value) {
//        delete hash.texto;
//    } else if (eval(document.getElementById("txt_pesquisa").value.length % 3) == 0) {
//        hash.texto = document.getElementById("txt_pesquisa").value;
//    }
//    historico.push(hash);
//    const tr = t.querySelectorAll("tr:not(.oculto)");
//    document.getElementById("total_registros").innerHTML = `${tr.length} registros encontrados`;
//}

const f = document.querySelector('.qbe');
combo.registra(document.getElementById('solicitante'), document.getElementById('j_solicitante'), filtraCombo, selecionaCombo, null);

pesquisa();