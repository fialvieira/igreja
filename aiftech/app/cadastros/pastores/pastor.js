function salva() {
    try {
        formulario.valida(f);
        if (document.getElementById('ata_entrada').value && !document.getElementById('dt_entrada').value) {
            throw 'Obrigatório informar a data de entrada.';
        }
        if (!document.getElementById('ata_entrada').value && document.getElementById('dt_entrada').value) {
            throw 'Obrigatório informar a ata de entrada.';
        }
        if (document.getElementById('ata_saida').value && !document.getElementById('dt_saida').value) {
            throw 'Obrigatório informar a data de saida.';
        }
        if (!document.getElementById('ata_saida').value && document.getElementById('dt_saida').value) {
            throw 'Obrigatório informar a ata de saida.';
        }
        if (!document.getElementById('ata_entrada').value && document.getElementById('ata_saida').value) {
            throw 'Não é possível informar uma Ata de Saída sem uma Ata de Entrada.';
        }

        ajax("salva.php", f, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                voltar();
                document.getElementById('salvar').classList.add('oculto');
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function verifica_ata(campo) {
    try {
        if (!campo.value) {
            return;
        }
        var param = query_string({
            'ata': campo.value
        });
        ajax("valida_ata.php", param, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                var pai = campo.parentNode.parentNode;
                pai.classList.remove('erro');
            } catch (e) {
                campo.focus();
                var pai = campo.parentNode.parentNode;
                pai.classList.add('erro');
                campo.value = '';
                alerta.erro(e, 10);
            }
        });
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function valida_titular(campo) {
    try {
        if (campo.value != 'T') {
            return;
        }
//    var param = query_string({
//      'ata': campo.value
//    });
        ajax("valida_titular.php", null, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
            } catch (e) {
                campo.focus();
                campo.value = '';
                alerta.erro(e);
            }
        });
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function voltar() {
    window.history.back();
}

var f = document.querySelector(".campos");