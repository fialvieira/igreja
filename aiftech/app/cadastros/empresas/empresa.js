function adicionaDados(linha) {
    document.getElementById('logradouro').value = linha.dataset.logradouro;
    document.getElementById('bairro').value = linha.dataset.bairro;
    document.getElementById('localidade').value = linha.dataset.localidade;
    document.getElementById('cep').dataset.id = linha.dataset.id;
    endereco_adicionado = true;
}

function filtraCombo(e, campo, janela) {
    var t = janela.querySelector("table tbody");
    full_text(e, t, campo, 1);
}

function validaEndereco() {
    try {
        if (document.getElementById('cep').value == '') {
            throw 'O campo Cep deve estar preenchido';
        }
        var strpar = query_string({
            'cep': document.getElementById('cep').value
        });
        ajax('consulta_endereco.php', strpar, function (html) {
            var tbody = document.getElementById('detalhes_grid').querySelector('tbody');
            tbody.innerHTML = html;
            combo.registra(document.getElementById('logradouro'), document.getElementById('j_enderecos'), filtraCombo, adicionaDados, null);
        });
    } catch (e) {
        document.getElementById('cep').focus();
        alerta.info(e, 5);
    }
}

function checaAjuste() {
    var flag_logradouro = (String(tiraAcentos(document.getElementById('logradouro').value)).toUpperCase() != logradouro) ? true : false;
    var flag_bairro = (String(tiraAcentos(document.getElementById('bairro').value)).toUpperCase() != bairro) ? true : false;
    var flag_cidade = (String(tiraAcentos(document.getElementById('localidade').value)).toUpperCase() != cidade) ? true : false;
    var flag_estado = (document.getElementById('uf').value != estado) ? true : false;
    ajustar = ((flag_logradouro || flag_bairro || flag_cidade || flag_estado) && !endereco_adicionado);
    ajustar = (ajustar) ? 1 : 0;
}

function consultaCep(campo) {
    try {
        if (cep != document.getElementById('cep').value) {
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

                if (r.erro) {
                    document.getElementById('logradouro').disabled = false;
                    document.getElementById('bairro').disabled = false;
                    document.getElementById('localidade').disabled = false;
                    document.getElementById('uf').disabled = false;

                    document.getElementById('cep').setAttribute('data-id', '');

                    document.getElementById('logradouro').setAttribute('required', '');
                    document.getElementById('bairro').setAttribute('required', '');
                    document.getElementById('localidade').setAttribute('required', '');
                    document.getElementById('uf').setAttribute('required', '');
                } else {
                    document.getElementById('cep').setAttribute('data-id', r.id);

                    if (r.logradouro != '') {
                        document.getElementById('logradouro').value = String(r.logradouro).toUpperCase();
                        logradouro = String(r.logradouro).toUpperCase();
                    } else {
                        document.getElementById('logradouro').setAttribute('required', '');
                        logradouro = '';
                    }
                    if (r.bairro != '') {
                        document.getElementById('bairro').value = String(r.bairro).toUpperCase();
                        bairro = String(r.bairro).toUpperCase();
                    } else {
                        bairro = '';
                    }
                    if (r.localidade != '') {
                        document.getElementById('localidade').value = String(r.localidade).toUpperCase();
                        cidade = String(r.localidade).toUpperCase();
                    } else {
                        cidade = '';
                    }
                    estado = r.uf;
                    let state = '';
                    if (isNaN(r.uf)) {
                        state = r.uf;
                    } else {
                        state = getEstado(r.uf, 'S');
                    }
                    if (state != '') {
                        var op = document.getElementById('uf');
                        for (var i = 0; i < op.length; i++) {
                            if (op[i].text == state) {
                                op.selectedIndex = i;
                            }
                        }
                    } else {
                        document.getElementById('uf').disabled = false;
                    }
                }
            });
        }

    } catch (err) {
        alerta.erro(err, 5);
    }
}

function salva() {
    try {
        formulario.valida(f);
        var strpar = montaParametros(f);

        ajax("salva.php", strpar, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                setTimeout(function () {
                    voltar();
                }, 1000);
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function montaParametros(campos) {
    checaAjuste();

    function query_string_elementos(elementos) {
        var dic = {};
        for (var i = 0; i < elementos.length; i++) {
            if (elementos[i].type != 'checkbox' && elementos[i].type != 'radio' || elementos[i].checked) {
                dic[elementos[i].name || elementos[i].id] = elementos[i].value;
            }
        }
        return query_string(dic);
    }

    var params = query_string_elementos(campos.querySelectorAll('input, select, textarea'));
    params += '&end_id=' + document.getElementById('cep').dataset.id;
    params += '&ajustado=' + ajustar;
    params += '&cep_real=' + document.getElementById('cep').value;
    return params;
}

function getCamposEndereco() {
    cep = document.getElementById('cep').value;
    logradouro = String(tiraAcentos(document.getElementById('logradouro').value)).toUpperCase();
    bairro = String(tiraAcentos(document.getElementById('bairro').value)).toUpperCase();
    cidade = String(tiraAcentos(document.getElementById('localidade').value)).toUpperCase();
    estado = document.getElementById('uf').value;
}

function voltar() {
    window.history.back();
}

var f = document.querySelector(".campos");
var ajustar = false;
var logradouro = '', bairro = '', cidade = '', estado = '', cep = '';
var endereco_adicionado = false;
getCamposEndereco();