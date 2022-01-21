function pesquisa() {
    try {
        var grid = document.querySelector(".container-grid .grid");

        function retorno(html) {
            grid.innerHTML = html;
            var tr = grid.querySelectorAll("table tbody tr");
            if (tr.length == 0) {
                grid.innerHTML = "";
            }
            document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
            if (document.getElementById("txt_pesquisa").value) {
                var hash = historico.hash();
                hash.texto = document.getElementById("txt_pesquisa").value;
                historico.push(hash);
            }
        }

        var parametros = query_string({
            "texto": document.getElementById("txt_pesquisa").value
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

function filtra(e) {
    var hash = historico.hash();
    var t = document.querySelector(".container-grid .grid table tbody");
    full_text(e, t, document.getElementById("txt_pesquisa"));
    if (!document.getElementById("txt_pesquisa").value) {
        delete hash.texto;
    } else if (eval(document.getElementById("txt_pesquisa").value.length % 3) == 0) {
        hash.texto = document.getElementById("txt_pesquisa").value;
    }
    historico.push(hash);
    var tr = t.querySelectorAll("tr:not(.oculto)");
    document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
}

function alteraClasse(a) {
    try {
        if (a.classList.contains('ligado')) {
            a.classList.remove('ligado');
            a.classList.add('desligado');
            a.setAttribute('title', 'Ativar conta');
        } else {
            a.classList.remove('desligado');
            a.classList.add('ligado');
            a.setAttribute('title', 'Desativar conta');
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function alteraAtivo(a) {
    try {
        var linha = a.parentNode.parentNode.parentNode;
        var strpar = query_string({
            'id': linha.dataset.id,
            'ativo': (a.classList.contains('ligado')) ? 'N' : 'S'
        });
        ajax('altera_ativo.php', strpar, function (json) {
            try {
                var r = JSON.parse(json);
                if (r.erro) {
                    throw r.mensagem;
                } else {
                    alerta.sucesso(r.mensagem, 5);
                    alteraClasse(a);
                }
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

pesquisa();