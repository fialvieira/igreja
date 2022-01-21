function consultaCep(campo) {
    try {
        if (document.getElementById('cep').value == '') {
            throw 'O campo cep não deve ficar em branco';
        }
        var strpar = query_string({
            'cep': campo.value
        });
        document.getElementById('msg').innerHTML = templates.CARREGANDO;
        ajax('consulta_cep.php', strpar, function (json) {
            var r = JSON.parse(json);
            document.getElementById('msg').innerHTML = '';
            document.getElementById('logradouro').disabled = true;
            document.getElementById('bairro').disabled = true;
            document.getElementById('localidade').disabled = true;
            document.getElementById('uf').disabled = true;
            if (r.erro) {
                document.getElementById('logradouro').disabled = false;
                document.getElementById('bairro').disabled = false;
                document.getElementById('localidade').disabled = false;
                document.getElementById('uf').disabled = false;

                document.getElementById('end_id').value = '';

                document.getElementById('logradouro').setAttribute('required', '');
                document.getElementById('bairro').setAttribute('required', '');
                document.getElementById('localidade').setAttribute('required', '');
                document.getElementById('uf').setAttribute('required', '');
            } else {

                document.getElementById('end_id').value = r.id;

                if (r.logradouro != '') {
                    document.getElementById('logradouro').value = String(r.logradouro).toUpperCase();
                } else {
                    document.getElementById('logradouro').disabled = false;
                    document.getElementById('logradouro').setAttribute('required', '');
                }
                if (r.bairro != '') {
                    document.getElementById('bairro').value = String(r.bairro).toUpperCase();
                } else {
                    document.getElementById('bairro').disabled = false;
                }
                if (r.localidade != '') {
                    document.getElementById('localidade').value = String(r.localidade).toUpperCase();
                } else {
                    document.getElementById('localidade').disabled = false;
                }
                var estado = '';
                if (isNaN(r.uf)) {
                    estado = r.uf;
                } else {
                    estado = getEstado(r.uf, 'S');
                }
                if (estado != '') {
                    var op = document.getElementById('uf');
                    for (var i = 0; i < op.length; i++) {
                        if (op[i].text == estado) {
                            op.selectedIndex = i;
                        }
                    }
                } else {
                    document.getElementById('uf').disabled = false;
                }
            }
        });
    } catch (err) {
        alerta.erro(err, 5);
    }
}

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

var f = document.querySelector(".campos");