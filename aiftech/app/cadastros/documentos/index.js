//function mostra_arquivos(id) {
//    var strpar = query_string({
//        'doc': id
//    });
//    ajax('arquivos.php', strpar, function (html) {
//        if (html) {
//            document.getElementById('detalhes_grid').innerHTML = html;
//            var hash = historico.hash();
//            hash.arquivos = '1';
//            historico.push(hash);
//            modal.abre('j_arquivos', function () {
//                var hash = historico.hash();
//                delete hash.arquivos;
//                historico.push(hash);
//            });
//        } else {
//            alerta.info('Esta Ata não possui arquivos anexos.', 3);
//        }
//    });
//}

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

        var parametros = query_string({});
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
        setTimeout(function () {
            filtra();
        }, 200);
    } else {
        document.getElementById("txt_pesquisa").innerHTML = "";
    }
    if (hash.arquivos) {
        modal.abre('j_arquivos', function () {
            var hash = historico.hash();
            delete hash.arquivos;
            historico.push(hash);
        });
    } else {
        modal.fecha();
    }
    if (hash.exclui) {
        modal.abre('md_excluir', function () {
            var hash = historico.hash();
            delete hash.exclui;
            historico.push(hash);
        });
    } else {
        modal.fecha();
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

function imprime(id, individual, lista_membros) {
    try {
        if (lista_membros == '') {
            throw 'Obrigatório ter pelo menos 01(hum) membro inserido.';
        }
        if (individual == 'S') {
            lista_membros = lista_membros.split(',');
            var type = (lista_membros.length == 1) ? '_self' : '_blank';
            for (var i = 0; i < lista_membros.length; i++) {
                window.open('imprime.php?id=' + id + '&membro=' + lista_membros[i], type);
            }
        } else {
            window.open('imprime.php?id=' + id + '&membro=' + lista_membros, '_self');
        }
    } catch (e) {
        alerta.erro(e, 10);
    }
}


function excluir(a) {
    btn = a;
    var hash = historico.hash();
    hash.exclui = 1;
    historico.push(hash);
    var node = btn.parentNode.parentNode.parentNode;
    var h1 = document.getElementById('md_excluir').querySelector('h1');
    h1.innerHTML = 'Confirma Exclusão Documento ' + node.cells[0].innerHTML;
    modal.abre('md_excluir', function () {
        var hash = historico.hash();
        delete hash.exclui;
        historico.push(hash);
    });
}

function exclui() {
    try {
        var parametros = query_string({
            'id': btn.dataset.id
        });

        ajax("exclui.php", parametros, function (json) {
            try {
                var r = JSON.parse(json);
                if (r.erro) {
                    throw r.mensagem;
                }

                var node = btn.parentNode.parentNode.parentNode;
                var pai = node.parentNode;
                if (pai) {
                    pai.removeChild(node);
                }

                modal.fecha();
                alerta.sucesso('Excluido.', 3);
            } catch (e) {
                alerta.erro(e, 6);
            }

        });
    } catch (e) {
        alerta.erro(e, 6);
    }
}
var btn;

pesquisa();