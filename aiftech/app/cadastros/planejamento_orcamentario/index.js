function pesquisa() {
    try {
        var grid = document.querySelector(".container-grid .grid");
        formulario.valida(f);
        ajax("pesquisa.php", f, function (html) {
            grid.innerHTML = html;
            var tr = grid.querySelectorAll("table tbody tr");
            if (tr.length == 0) {
                grid.innerHTML = "";
            }
            document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
            var hash = historico.hash();
            hash.ano = document.getElementById("ano").value;
            hash.mes = document.getElementById("mes").value;
            historico.push(hash);
            setTimeout(function(){
                filtra(evento);
            },100);
        });
        grid.innerHTML = templates.CARREGANDO;
        document.getElementById("total_registros").innerHTML = "";
    } catch (e) {
        alerta.erro(e, 8);
    }
}

function filtra(e) {
    var hash = historico.hash();
    console.log(hash);
    console.log(document.getElementById('txt_pesquisa').value);
    var t = document.querySelector(".container-grid .grid table tbody");
    full_text(e, t, document.getElementById("txt_pesquisa"));
    if (!document.getElementById("txt_pesquisa").value) {
        delete hash.texto;
    } else if (eval(document.getElementById("txt_pesquisa").value.length % 3) == 0) {
        hash.texto = document.getElementById("txt_pesquisa").value;
    }
    historico.push(hash);
    console.log(hash);
    var tr = t.querySelectorAll("tr:not(.oculto)");
    document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
}

function replicar() {
    document.getElementById('ano_de').value = document.getElementById('ano').value;
    document.getElementById('mes_de').value = document.getElementById('mes').value;
    modal.abre('j_replicar', function () {
        var campo = document.getElementById('j_replicar').querySelector('.campos .nao-preenchido');
        var hash = historico.hash();
        delete hash.replicar;
        historico.push(hash);
        if (campo) {
            campo.classList.remove('nao-preenchido');
        }
        document.getElementById('ano_de').value = document.getElementById('ano').value;
        document.getElementById('mes_de').value = document.getElementById('mes').value;
        document.getElementById('ano_para').value = '';
        document.getElementById('mes_para').value = '';
    });
    var hash = historico.hash();
    hash.replicar = 1;
    historico.push(hash);
}

function replica() {
    try {
        formulario.valida(document.getElementById('j_replicar').querySelector('.campos'));
        if (document.getElementById('ano_para').value < document.getElementById('ano_de').value) {
            throw 'Obrigatório o campo "De Ano" ser menor que o campo "Para Ano".';
        } else if (document.getElementById('ano_para').value == document.getElementById('ano_de').value) {
            if (document.getElementById('mes_de').value == '' && document.getElementById('mes_para').value == '') {
                throw 'Obrigatório o campo "De Ano" ser menor que o campo "Para Ano".';
            }
            if (document.getElementById('mes_para').value != '' && document.getElementById('mes_para').value < document.getElementById('mes_de').value) {
                throw 'Obrigatório o campo "De Mês" ser menor que o campo "Para Mês".';
            }
        }
        if (document.getElementById('mes_para').value != '' && document.getElementById('mes_de').value == '') {
            throw 'Obrigatório preencher o campo "De Mês" quando o campo "Para Mês" esta preenchido.';
        }

        var param = query_string({
            "ano_de": document.getElementById('ano_de').value,
            "ano_para": document.getElementById('ano_para').value,
            "mes_de": document.getElementById('mes_de').value,
            "mes_para": document.getElementById('mes_para').value
        });
        var msg_de = (document.getElementById('mes_de').value != '') ?
                document.getElementById('mes_de').options[document.getElementById('mes_de').selectedIndex].innerText + '/' +
                document.getElementById('ano_de').value : document.getElementById('ano_de').value;
        var msg_para = (document.getElementById('mes_para').value != '') ?
                document.getElementById('mes_para').options[document.getElementById('mes_para').selectedIndex].innerText + '/' +
                document.getElementById('ano_para').value : document.getElementById('ano_para').value;
        ajax("replica.php", param, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Réplica de planejamento de " + msg_de + " para " + msg_para + " realizada com sucesso.", 3);
                setTimeout(function () {
                    pesquisa();
                }, 3000);

            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        modal.fecha();
        alerta.info("Replicando planejamento...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

historico.load(function (hash) {
    if (hash.ano || hash.mes || hash.texto) {
        document.getElementById("ano").value = hash.ano;
        document.getElementById("mes").value = hash.mes;
        document.getElementById('txt_pesquisa').value = (hash.texto)? hash.texto : '';
        pesquisa();
        setTimeout(function () {
            filtra(evento);
        }, 100);
    } else {
        document.getElementById("mes").value = "";
    }
    if (hash.replicar) {
        document.getElementById('ano_de').value = document.getElementById('ano').value;
        document.getElementById('mes_de').value = document.getElementById('mes').value;
        modal.abre('j_replicar', function () {
            var hash = historico.hash();
            delete hash.replicar;
            historico.push(hash);
            document.getElementById('ano_de').value = document.getElementById('ano').value;
            document.getElementById('mes_de').value = document.getElementById('mes').value;
            document.getElementById('ano_para').value = '';
            document.getElementById('mes_para').value = '';
        });
    } else {
        modal.fecha();
    }
});
var evento = new Event("keyup");
evento.keyCode = 13;

var f = document.querySelector('.campos');
pesquisa();