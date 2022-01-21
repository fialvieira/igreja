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

function selecionaCombo(linha) {
    document.getElementById(linha.dataset.campo).value = linha.dataset.nome;
    document.getElementById(linha.dataset.campo).dataset.id = linha.dataset.id;
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

function verificaCargoDepartamento(cargo, departamento) {
    var strpar = query_string({
        'cargo': cargo,
        'departamento': departamento
    });
    ajax('verifica_cargo_dep.php', strpar, function (json) {
        try {
            var r = JSON.parse(json);
            if (r.erro) {
                throw 'Erro ao consultar base de Membros';
            } else {
                var msg = r.ret['nome'] + ' está com status ativo para o cargo ' + r.ret['cargo'] + ' no departamento ' + r.ret['departamento'] + '. Favor verificar!';
                alerta.info(msg, 10);
            }
        } catch (e) {

        }
    });
}

function adicionaCargo() {
    try {
        var cargo = document.getElementById('sel_cargo');
        var departamento = document.getElementById('sel_cargo_dep');
        var periodo = document.getElementById('periodo');
        var table = document.getElementById('ctn_cargos').querySelector('table');
        var idx = 0;
        if (!Numeros.eInteiro(periodo)) {
            periodo.focus();
        }
        if (cargo.selectedIndex != 0 && departamento.selectedIndex != 0 && (periodo.value != '' && periodo.value > 1900 /*&& periodo.value <= (new Date()).getFullYear()*/)) {
            verificaCargoDepartamento(cargo.value, departamento.value);

            if (table.classList.contains('esconde')) {
                table.classList.remove('esconde');
            }

            var tbody = document.getElementById('ctn_cargos').querySelector('tbody');

            idx = retornaMaxRowIndex(tbody, periodo.value);

            var row = tbody.insertRow(idx);

            row.dataset.cargoid = cargo.value;
            row.dataset.depid = departamento.value;
            row.dataset.periodo = periodo.value;

            var cels = new Array();
            cels[0] = row.insertCell(0);
            cels[0].dataset.titulo = 'Período';
            cels[1] = row.insertCell(1);
            cels[1].dataset.titulo = 'Cargo';
            cels[2] = row.insertCell(2);
            cels[2].dataset.titulo = 'Departamento';
            cels[3] = row.insertCell(3);

            cels[0].innerHTML = periodo.value;
            cels[1].innerHTML = cargo.options[cargo.selectedIndex].text;
            cels[2].innerHTML = departamento.options[departamento.selectedIndex].text;

            cels[3].classList.add('acoes');
            cels[3].innerHTML = '<div><a class="desligado" title="Ativar" onclick="liga_desliga(this)"></a></div>';
            row.dataset.ativo = 'N';

            adicionado = true;
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function liga_desliga(campo) {
    var linha = campo.parentNode.parentNode.parentNode;
    status_alterado = true;
    if (campo.classList.contains('ligado')) {
        campo.classList.remove('ligado');
        campo.classList.add('desligado');
        linha.dataset.ativo = 'N';
    } else {
        campo.classList.remove('desligado');
        campo.classList.add('ligado');
        linha.dataset.ativo = 'S';
    }
    if (campo.getAttribute('title') == 'Desativar') {
        campo.setAttribute('title', 'Ativar');
    } else {
        campo.setAttribute('title', 'Desativar');
    }

}

Array.prototype.max = function () {
    return Math.max.apply(null, this);
};

Array.prototype.min = function () {
    return Math.min.apply(null, this);
};

function retiraBotaoAtivo(tabela, pos) {
    var total = tabela.getElementsByTagName('tr');
    if (total.length > 0) {
        for (var i = pos; i < total.length; i++) {
            total[i].cells[3].innerHTML = '';
            total[i].dataset.ativo = 'N';
        }
    }
}

function retornaMaxRowIndex(tabela, periodo) {
    var total = tabela.getElementsByTagName('tr');
    var indice = 0;
    var verificado = false;
    if (total.length > 0) {
        for (var i = 0; i < total.length; i++) {
            if (parseInt(periodo) > parseInt(total[i].cells[0].innerText)) {
                indice = (total[i].rowIndex == 0) ? 0 : total[i].rowIndex - 1;
                verificado = true;
                break;
            }
        }
        if (!verificado) {
            indice = total.length;
        }
    }
    return indice;
}

function valida(id, ctn) {
    var a_ig = ctn.querySelectorAll('a');
    var ret = true;
    for (var i = 0; i < a_ig.length; i++) {
        if (parseInt(id) === parseInt(a_ig[i].getAttribute('data-id'))) {
            ret = false;
        }
    }
    return ret;
}

function validaCombo(campo) {
    try {
        var pai = campo.parentNode.parentNode;
        var label = pai.querySelector("div.rotulo label").innerText;
        if (!campo.dataset.id && campo.value != '') {
            campo.value = '';
            throw 'O valor preenchido não consta em nossa base de ' + label;
        }
    } catch (e) {
        formulario.mensagemCampo(campo, e, true);
    }
}

function preAdicionaLinha(linha){
    var campo = linha.dataset.campo;
    var pai = document.getElementById(campo).parentNode;
    var ctn = pai.querySelector("div#ctn_igreja_anterior").id;
    adicionaLinha(linha, ctn);
}

function adicionaLinha(campo, ctn) {
    var v_campo = '';
    var t_campo = '';
    if (campo.id != 'sel_min_int' && campo.id != 'sel_dons') {
        v_campo = campo.dataset.id;
        t_campo = campo.dataset.nome;
    } else {
        v_campo = campo.value;
        if (v_campo != '') {
            t_campo = campo.options[campo.selectedIndex].text;
        }
    }
    if (valida(v_campo, document.getElementById(ctn))) {
        var a_ctn = ctn.replace('ctn', 'a');
        document.getElementById(ctn).insertAdjacentHTML('beforeend',
            '<div class="' + a_ctn + '">' +
            '  <a class="acao excluir" onclick="remover(this)" data-id="' + v_campo + '"></a>' +
            '  <label>' + t_campo + '</label>' +
            '</div>');
    }
}

function carregaDepartamentos(campo) {
    try {
        document.getElementById('sel_cargo_dep').value = 0;
        document.getElementById('sel_cargo_dep').innerHTML = '';
        var strpar = query_string({
            'id': campo.value
        });
        ajax("carrega_dep.php", strpar, function (resp) {
            try {
                if (resp.indexOf("vinculação") > -1) {
                    throw resp;
                }
                document.getElementById('sel_cargo_dep').innerHTML = resp;
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function remover(campo) {
    var node = campo.parentNode;
    var p = node.parentNode;
    if (p) {
        p.removeChild(node);
    }
}

function mudarStatus(campo) {
    if (campo.classList.contains('desligado')) {
        campo.classList.remove('desligado');
        campo.classList.add('ligado');
    } else {
        campo.classList.remove('ligado');
        campo.classList.add('desligado');
    }
}

function limpaCampos() {
    ajustar = false;
    status_alterado = false;
    var inputs = document.querySelectorAll('input');
    var selects = document.querySelectorAll('select');
    var txarea = document.querySelectorAll('textarea');
    var a_excluir = document.querySelectorAll('a.acao.excluir');
    var table_cargos = document.getElementById('tbl_cargos');
    var tbody = table_cargos.querySelector('tbody');
    tbody.innerHTML = '';
    if (!table_cargos.classList.contains('escode')) {
        table_cargos.classList.add('esconde');
    }
    if (inputs != null && inputs.length != 0) {
        for (var i = 0; i < inputs.length; i++) {
            inputs[i].value = '';
        }
    }
    if (selects != null && selects.length != 0) {
        for (var i = 0; i < selects.length; i++) {
            selects[i].value = ''; //-1
        }
    }
    if (txarea != null && txarea.length != 0) {
        for (var i = 0; i < txarea.length; i++) {
            txarea[i].value = '';
        }
    }
    if (a_excluir != null && a_excluir.length != 0) {
        for (var i = 0; i < a_excluir.length; i++) {
            remover(a_excluir[i]);
        }
    }
}

function salva(tp_salvamento) {
    try {
        formulario.valida(f);
        var strpar = montaParametros(f);
        ajax("salva.php", strpar, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 5);
                salvaArquivo(r.id);
                if (tp_salvamento == 'A') {
                    voltar();
                } else {
                    limpaCampos();
                }
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function gravaDepartamentosInteresse() {
    var a_interesse = document.getElementById('ctn_dep_interesse').querySelectorAll('a');
    for (var i = 0; i < a_interesse.length; i++) {
        interesses[i] = a_interesse[i].getAttribute('data-id');
    }
}

function gravaDons() {
    var a_dons = document.getElementById('ctn_dom').querySelectorAll('a');
    for (var i = 0; i < a_dons.length; i++) {
        dons[i] = a_dons[i].getAttribute('data-id');
    }
}

function gravaIgrejasAnteriores() {
    var a_ig = document.getElementById('ctn_igreja_anterior').querySelectorAll('a');
    for (var i = 0; i < a_ig.length; i++) {
        igs_ant[i] = a_ig[i].getAttribute('data-id');
    }
}

function gravaTextosSelects() {
    var selects = document.querySelectorAll('select');
    console.log(selects);
    if (selects != null && selects.length != 0) {
        console.log(selects.length);
        for (var i = 0; i < selects.length; i++) {
            console.log('select: ');
            console.log(selects[i]);
            console.log('index: '+selects[i].selectedIndex);
            console.log('options: ');
            console.log(selects[i].options);
            if (selects[i].options[selects[i].selectedIndex].text != '') {
                sel_txts += selects[i].options[selects[i].selectedIndex].text + ' ';
            }
        }
    }
}

function gravaCargosDepartamentos() {
    var linhas = document.getElementById('ctn_cargos').querySelectorAll('table tbody tr');
    for (var i = 0; i < linhas.length; i++) {
        cargos_deps.push({
            'cargo_id': linhas[i].dataset.cargoid,
            'departamento_id': linhas[i].dataset.depid,
            'periodo': linhas[i].dataset.periodo,
            'ativo': linhas[i].dataset.ativo
        });
    }
    cargos_deps_op = 'I';
}

function montaParametros(campos) {
    checaAjuste();
    gravaIgrejasAnteriores();
    gravaDons();
    gravaDepartamentosInteresse();
    gravaTextosSelects();
    if (adicionado || status_alterado) {
        gravaCargosDepartamentos();
    } else {
        cargos_deps_op = '';
        cargos_deps = [];
    }

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
    params += '&dons=' + dons;
    params += '&ig_ant=' + igs_ant;
    params += '&end_id=' + document.getElementById('cep').dataset.id;
    params += '&deps_int=' + interesses;
    params += '&sel_txts=' + sel_txts;
    params += '&carg_dep=' + JSON.stringify(cargos_deps);
    params += '&cargos_deps_op=' + cargos_deps_op;
    params += '&ajustado=' + ajustar;
    params += '&cep_real=' + document.getElementById('cep').value;
    return params;
}

function voltar() {
    window.history.back();
}

function validaUsuario(campo) {
    var strpar = query_string({
        'cpf': campo.value
    });
    ajax('pesquisa_usuario_membro.php', strpar, function (json) {
        try {
            var r = JSON.parse(json);
            if (r.ERRO) {
                campo.value = '';
                campo.focus();
                throw r.MSG;
            } else {
                if (r.USERS) {
                    alerta.info(r.MSG, 3);
                    document.getElementById('nome').value = r.NOME;
                    document.getElementById('cel').value = r.CELULAR;
                    document.getElementById('email').value = r.EMAIL;
                }
            }
        } catch (e) {
            alerta.info(e, 5);
        }
    });
}

function limpaCampoArquivo(campo) {
    campo.value = "";
}

function seleciona_arquivo(campo) {
    var TAMANHO_MAXIMO = 500;
    try {
        if (campo.files.length) {
            var file = campo.files[0];
            var tamanho = Math.round(file.size / 1024);
            var extensao = file.type;

            if (tamanho > TAMANHO_MAXIMO) {
                throw 'Arquivo muito grande: ' + tamanho + ' KB. Máximo permitido: ' + TAMANHO_MAXIMO + ' KB.';
            }
            if (extensao != 'image/jpeg') {
                throw 'Permitido apenas arquivo do tipo jpg.';
            }
            var nome = file.name;
            var container = document.getElementById('ctn_foto');
            var reader = new FileReader();
            reader.onload = function (e) {
                container.insertAdjacentHTML('beforeend',
                    ' <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>' +
                    ' <img id="img_foto" class="imagem" src="' + e.target.result + '">');
            };
            reader.readAsDataURL(file);
            campo.disabled = true;
            up = true;
            ex = false;
        }
    } catch (e) {
        document.body.style.cursor = '';
        alerta.erro(e, 5);
    }
}

function salvaArquivo(id) {
    try {
        if (up || ex) {
            var data = new FormData();
            data.append('id', id);
            if (up) {
                if (document.getElementById('arquivo_foto').files[0] != null) {
                    data.append('arquivo', document.getElementById('arquivo_foto').files[0]);
                    ajax("salvaArquivo.php", data, function (resp) {
                        try {
                            var r = JSON.parse(resp);
                            if (r.erro) {
                                throw r.mensagem;
                            }
                        } catch (e) {
                            alerta.erro(e, 10);
                            return;
                        }
                    });
                }
            } else {
                ajax("exclui_arquivo.php", data, function (resp) {
                    try {
                        var r = JSON.parse(resp);
                        if (r.erro) {
                            throw r.mensagem;
                        }
                    } catch (e) {
                        alerta.erro(e, 10);
                        return;
                    }
                });
            }
        }
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function remove_arquivo(campo) {
    var ctn_foto = campo.parentNode;
    ctn_foto.innerHTML = '';
    document.getElementById('arquivo_foto').disabled = false;
    ex = true;
    up = false;
}

function mostraCampo(campo, id) {
    if (campo.value == 1) {
        document.getElementById(id).style.display = 'table-row';
    } else {
        document.getElementById(id).style.display = 'none';
    }
}

function getCamposEndereco() {
    cep = document.getElementById('cep').value;
    logradouro = String(tiraAcentos(document.getElementById('logradouro').value)).toUpperCase();
    bairro = String(tiraAcentos(document.getElementById('bairro').value)).toUpperCase();
    cidade = String(tiraAcentos(document.getElementById('localidade').value)).toUpperCase();
    estado = document.getElementById('uf').value;
}

var ajustar = false;
var logradouro = '', bairro = '', cidade = '', estado = '', cep = '';
var up = false;
var ex = false;
var cargos_deps_op = '';
/*I - inserção, U - update*/
var adicionado = false;
var endereco_adicionado = false;
var status_alterado = false;
var sel_txts = '';
var cargos_deps = new Array();
var interesses = new Array();
var igs_ant = new Array();
var dons = new Array();
var opt = new Array();
var f = document.querySelector(".container");

mostraCampo(document.getElementById('estadocivil'), 'campo_dt_casamento');
getCamposEndereco();
combo.registra(document.getElementById('igrejabatismo'), document.getElementById('j_igrejabatismo'), filtraCombo, selecionaCombo, validaCombo);
combo.registra(document.getElementById('sel_ig_ant'), document.getElementById('j_sel_ig_ant'), filtraCombo, preAdicionaLinha, validaCombo);
combo.registra(document.getElementById('pastorbatismo'), document.getElementById('j_pastorbatismo'), filtraCombo, selecionaCombo, null);
combo.registra(document.getElementById('ultimaigreja'), document.getElementById('j_ultimaigreja'), filtraCombo, selecionaCombo, null);