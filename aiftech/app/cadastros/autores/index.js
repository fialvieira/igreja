function pesquisa() {
    try {
        var grid = document.querySelector(".container-grid .grid");
        
        function retorno(html) {
            grid.innerHTML = html;
            var tr = grid.querySelectorAll("table tbody tr");
            if (tr.length == 0) {
                grid.innerHTML = "";
                alerta.erro("Nenhum registro encontrado",3);
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

//function excluir () {
//    
//}
//
//function exclui() {
//    try {
//        formulario.valida(f);
//
//        ajax("../../core/gerador/salva.php", f, function (resp) {
//            try {
//                var r = JSON.parse(resp);
//                if (r.erro) {
//                    throw r.mensagem;
//                }
//                alerta.sucesso("Salvo.");
//                setTimeout(function () {
//                    voltar();
//                }, 500);
//            } catch (e) {
//                alerta.erro(e, 10);
//            }
//        });
//        alerta.info("Salvando...");
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
//function enter(e) {
//    if (e.keyCode == 13) {
//        pesquisa();
//        document.getElementById("txt_pesquisa").focus();
//        return false;
//    }
//}
//
//function pesquisar(e) {
//    if (e.keyCode != 13) {
//        var tam = eval(document.getElementById("txt_pesquisa").value.length % 4);
//        if (tam == 0) {
//            pesquisa();
//            document.getElementById("txt_pesquisa").focus();
//            return false;
//        }
//    }
//}
pesquisa();