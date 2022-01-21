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
                filtra(evento);
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

function cancelar(a) {
    var tr = a.parentNode.parentNode.parentNode;
    document.getElementById('btn_cancelar').setAttribute('onclick', 'cancela(' + tr.cells[0].innerText + ')');
    modal.abre('j_cancela', function () {
        var campo = document.getElementById('j_cancela').querySelector('.campos .nao-preenchido');
        var hash = historico.hash();
        delete hash.cancela;
        historico.push(hash);
        if (campo) {
            campo.classList.remove('nao-preenchido');
        }
        document.getElementById('justificativa').value = '';
    });
    var hash = historico.hash();
    hash.cancela = tr.cells[0].innerText;
    historico.push(hash);
}

function cancela(id) {
    try {
        formulario.valida(document.getElementById('j_cancela').querySelector('.campos'));
        var param = query_string({
            "codigo": id,
            "cancela": 'S',
            "justificativa": document.getElementById('justificativa').value
        });
        ajax("salva.php", param, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                pesquisa();
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        modal.fecha();
    } catch (e) {
        alerta.erro(e, 10);
    }
}

historico.load(function (hash) {
    if (hash.texto) {
        document.getElementById("txt_pesquisa").value = hash.texto;
        delete hash.texto;
        historico.push(hash);
        pesquisa();
        setTimeout(function () {
            filtra(evento);
        }, 100);
    } else {
        document.getElementById("txt_pesquisa").innerHTML = "";
    }
    if (hash.cancela) {
        document.getElementById('btn_cancelar').setAttribute('onclick', 'cancela(' + hash.cancela + ')');
        modal.abre('j_cancela', function () {
            var hash = historico.hash();
            delete hash.cancela;
            historico.push(hash);
        });
    } else {
        modal.fecha();
    }
});

var evento = new Event("keyup");
evento.keyCode = 13;

pesquisa();