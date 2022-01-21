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
                var hash = historico.hash();
                hash.texto = document.getElementById("txt_pesquisa").value;
                historico.push(hash);
            }
        }

//        var ctn = document.body.querySelector("div.container-grid");
        var parametros = query_string({
//            "tabela": tabela,
            "texto": document.getElementById("txt_pesquisa").value
        });
        ajax("pesquisa.php", parametros, retorno);
        grid.innerHTML = templates.CARREGANDO;
        document.getElementById("total_registros").innerHTML = "";
    } catch (e) {
        alerta.erro(e, 8);
    }
}

//function deletaLinha(tabela, linha) {
//    tabela.deleteRow(linha);
//}
//
//function excluir(id, campo) {
//    try {
//        var parametros = query_string({
//            "id": id
//        });
//        ajax("exclui.php", parametros, function (resp) {
//            try {
//                var r = JSON.parse(resp);
//                if (r.erro) {
//                    throw r.mensagem;
//                }
//                alerta.sucesso(r.mensagem);
//                deletaLinha(document.getElementById('tbl_departamentos'), campo.parentNode.parentNode.parentNode.rowIndex);
//            } catch (e) {
//                alerta.erro(e, 10);
//            }
//        });
//        alerta.info("Excluindo...");
//    } catch (e) {
//        alerta.erro(e, 10);
//    }
//}

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

function liga_desliga(a) {
    try {
        if (a.classList.contains("ligado")) {
            a.classList.remove("ligado");
            a.classList.add("desligado");
        } else {
            a.classList.remove("desligado");
            a.classList.add("ligado");
        }
        var linha = a.parentNode.parentNode.parentNode;
        var ativo = (a.classList.contains("ligado")) ? "S" : "N";
        var param = query_string({
            "id": a.getAttribute('data-id'),
            "ativo": ativo
        });
        ajax("altera_status.php", param, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
    } catch (e) {
        alerta.erro(e, 10);
    }
}

pesquisa();