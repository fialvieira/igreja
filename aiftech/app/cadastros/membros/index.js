function abreDetalhes(id) {
    var strpar = query_string({
        'id': id
    });
    ajax('pesquisa.php', strpar, function (html) {
        document.getElementById('detalhes_grid').innerHTML = html;
    });
    modal.abre('j_detalhes_membro');
}

function limpaGrid() {
    var grid = document.querySelector(".container-grid .grid");
    var total = document.getElementById("total_registros");
    total.innerHTML = "";
    grid.innerHTML = "";
    var hash = historico.hash();
    if (hash.texto) {
        document.getElementById("txt_pesquisa").value = "";
        delete hash.texto;
        historico.push(hash);
    }
}

function pesquisa() {
    try {
        var grid = document.querySelector(".container-grid .grid");

        function retorno(html) {
            grid.innerHTML = html;
            var tr = grid.querySelectorAll("table tbody tr");
            if (tr.length == 0) {
                grid.innerHTML = "";
                alerta.erro("Nenhum registro encontrado", 3);
            }
            document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
            if (document.getElementById("txt_pesquisa").value) {
                hash.texto = document.getElementById("txt_pesquisa").value;
                historico.push(hash);
            }
        }

        var parametros = query_string({
            "texto": document.getElementById("txt_pesquisa").value,
            'status': (document.getElementById('sel_status')) ? document.getElementById('sel_status').value : ''
        });
        ajax("pesquisa.php", parametros, retorno);
        grid.innerHTML = templates.CARREGANDO;
        document.getElementById("total_registros").innerHTML = "";
    } catch (e) {
        alerta.erro(e, 8);
    }
}

historico.load(function (hash) {
    if (hash.texto) {
        document.getElementById("txt_pesquisa").value = hash.texto;
        delete hash.texto;
        historico.push(hash);
        pesquisa();
    } else {
        document.getElementById("txt_pesquisa").innerHTML = "";
    }
});

function enter(e) {
    if (e.keyCode == 13) {
        pesquisa();
        document.getElementById("txt_pesquisa").focus();
        return false;
    }
}

function pesquisar(e) {
    if (e.keyCode != 13) {
        var tam = eval(document.getElementById("txt_pesquisa").value.length % 4);
        if (tam == 0 && document.getElementById("txt_pesquisa").value != '') {
            pesquisa();
            document.getElementById("txt_pesquisa").focus();
            return false;
        } else {
            if (document.getElementById("txt_pesquisa").value == '') {
                if (hash.texto) {
                    delete hash.texto;
                    historico.push(hash);
                }
                pesquisa();
            }
        }
    }
}

var perfil = window.sessionStorage.getItem('perfil');
var hash = historico.hash();
pesquisa();