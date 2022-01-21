function salva() {
    try {
        formulario.valida(f);
        ajax("salva.php", f, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                voltar();
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function voltar() {
    window.history.back();
}

function atualizaSaldos() {
    try {
        if (document.getElementById('valor').value != '') {
            if (document.getElementById('conta_origem').value != '') {
                console.log(saldo_origem_inicial);
                document.getElementById('saldo').value = Numeros.formata(parseFloat(saldo_origem_inicial) - parseFloat(document.getElementById('valor').value), 2, ',');
            }
            if (document.getElementById('conta_destino').value != '') {
                console.log(saldo_origem_inicial);
                document.getElementById('saldo_destino').value = Numeros.formata(parseFloat(saldo_destino_inicial) + parseFloat(document.getElementById('valor').value), 2, ',');
            }
        }
    } catch (e) {
        alerta.erro(e, 3);
    }
}

function carregaSaldo(campo) {
    try {
        if (campo.value != '') {
            var strpar = query_string({
                'conta_id': campo.value
            });
            ajax('carrega_saldo.php', strpar, function (json) {
                try {
                    var r = JSON.parse(json);
                    if (r.erro) {
                        throw r.mensagem;
                    } else {
                        if (campo.id === 'conta_origem') {
                            document.getElementById('saldo').value = Numeros.formata((!isNaN(r.saldo)) ? r.saldo : 0.00, 2, ',');
                            saldo_origem_inicial = (!isNaN(r.saldo)) ? r.saldo : 0.00;
                            ocultaOpcao(document.getElementById('conta_destino'), campo.value);
                        } else {
                            document.getElementById('saldo_destino').value = Numeros.formata((!isNaN(r.saldo)) ? r.saldo : 0.00, 2, ',');
                            saldo_destino_inicial = (!isNaN(r.saldo)) ? r.saldo : 0.00;
                        }
                        atualizaSaldos();
                    }
                } catch (e) {
                    alerta.erro(e, 3);
                }
            });
        } else {
            document.getElementById('saldo').value = '';
            ocultaOpcao(document.getElementById('conta_destino'), campo.value);
        }
    } catch (e) {
        alerta.erro(e, 3);
    }
}

function ocultaOpcao(campo, valor) {
    try {
        campo.value = '';
        var options = campo.querySelectorAll('option');
        for (var i = 1; i < options.length; i++) {
            if (options[i].value == valor) {
                options[i].classList.add('oculto');
            } else {
                options[i].classList.remove('oculto');
            }
        }
    } catch (e) {
        alerta.erro(e, 3);
    }
}

var f = document.querySelector(".campos");
var saldo_origem_inicial, saldo_destino_inicial = 0;