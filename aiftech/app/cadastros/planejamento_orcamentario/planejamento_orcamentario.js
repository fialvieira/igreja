function salva() {
    try {
        formulario.valida(f);
        var params = query_string({
            'codigo': document.getElementById('codigo').value,
            'ano': (document.getElementById('ano')) ? document.getElementById('ano').value : '',
            'mes': (document.getElementById('mes')) ? document.getElementById('mes').value : '',
            'conta': (document.getElementById('conta')) ? document.getElementById('conta').value : '',
            'valor_previsto': document.getElementById('valor_previsto').value,
            'replicar_valor': replicar_valor
        });
        ajax("salva.php", params, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                if (document.getElementById('codigo').value != '') {
                    voltar();
                } else {
                    limpa();
                }
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function confirmar() {
    if (document.getElementById('codigo').value != '') {
        modal.abre('j_confirma', function () {
            window.history.back();
//            var hash = historico.hash();
//            delete hash.confirma;
//            historico.push(hash);
//            replicar_valor = false;
//            salva();
        });
        var hash = historico.hash();
        hash.confirma = 1;
        historico.push(hash);
    } else {
        replicar_valor = false;
        salva();
    }
}

function confirma(valor) {
    modal.fecha();
    replicar_valor = false;
    if (valor == 'S') {
        replicar_valor = true;
    }
    salva();
}

function limpa() {
    document.getElementById('conta').value = '';
    document.getElementById('valor_previsto').value = '';
    document.getElementById('mes').focus();
}

function voltar() {
    window.history.back();
}

historico.load(function (hash) {
    if (hash.confirma) {
        modal.abre('j_confirma', function () {
            window.history.back();
//            var hash = historico.hash();
//            delete hash.confirma;
//            historico.push(hash);
        });
    } else {
        modal.fecha();
    }
});

var f = document.querySelector(".campos");
var replicar_valor = false;
