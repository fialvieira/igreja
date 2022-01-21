function exporta() {
    try {
        var strpar = montaParametros(f);
        alerta.info('Gerando relatório...', 5);
        window.open('igreja.php?' + strpar, '_self');
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function pesquisa() {
    try {
        var grid = document.querySelector(".container-grid .grid");
        var strpar = montaParametros(f);
        grid.innerHTML = templates.CARREGANDO;
        document.getElementById("total_registros").innerHTML = "";
        ajax('pesquisa.php', strpar, function (html) {
            try {
                grid.innerHTML = html;
                var tr = grid.querySelectorAll("table tbody tr");
                if (tr.length == 0) {
                    grid.innerHTML = "";
                    throw "Nenhum registro encontrado";
                }
                var hash = historico.hash();
                document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
                document.getElementById('campo_ft').style.display = 'inline-block';
                hash.status = document.getElementById('status').value;
                hash.associacao = document.getElementById('associacao').value;
                historico.push(hash);
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function montaParametros(campos) {
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
    return params;
}

function full_text(e, table, caixa, div) {
    try {
        div = 3;
        var grid = document.querySelector(".container-grid .grid");
        var tr_total = grid.querySelectorAll("table tbody tr");
        var tr;
        if (e) {
            var key = e.keyCode;
        } else {
            key = 13;
        }
        var tam = eval(caixa.value.length % div);
        var indice = '';
        if (key == 13) {
            tam = 0;
        }
        if (tam == 0) {
            var regex;
            for (var i = 0; i < table.rows.length; i++) {
                indice = '';
                for (var j = 0; j < table.rows[i].cells.length; j++) {
                    indice += table.rows[i].cells[j].innerHTML + ' ';
                }
                if (caixa.value) {
                    regex = regex_ft(caixa);
                    if (indice.search(regex) == -1) {
                        table.rows[i].classList.add('oculto');
                    } else {
                        table.rows[i].classList.remove('oculto');
                    }
                } else {
                    table.rows[i].classList.remove('oculto');
                }
            }
            tr = grid.querySelectorAll("table tbody tr:not(.oculto)");
            if (tr_total == 0 && tr.length == 0) {
                /*grid.innerHTML = "";*/
                throw "Nenhum registro encontrado";
            }
            document.getElementById("total_registros").innerHTML = tr.length + " de " + tr_total.length + " registros encontrados";
        }
        if (caixa.value == '') {
            document.getElementById("total_registros").innerHTML = tr_total.length + " registros encontrados";
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function filtrar(e) {
    var hash = historico.hash();
    var t = document.querySelector(".grid table tbody");
    full_text(e, t, document.getElementById("ft_txt"));
    if (!document.getElementById("ft_txt").value) {
        /*delete hash.texto;*/
    } else if (eval(document.getElementById("ft_txt").value.length % 3) == 0) {
        hash.texto = document.getElementById("ft_txt").value;
    }
    historico.push(hash);
}

historico.load(function (hash) {
    if (hash.status || hash.quorum || hash.local) {
        document.getElementById("status").value = hash.status;
        document.getElementById('associacao').value = hash.associacao;
        pesquisa();
    }
    if (hash.texto) {
        document.getElementById('ft_txt').value = hash.texto;
    }
});

var f = document.querySelector(".qbe");
var hash = historico.hash();
var evento = new Event("keyup");
evento.keyCode = 13;