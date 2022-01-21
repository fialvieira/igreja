function limpaCampos() {
    document.getElementById('tipo_relacionamento').value = -1;
    document.getElementById('participantes').value = '';
}

function adicionaParenteCampo(linha) {
    document.getElementById('participantes').value = linha.dataset.nome;
    document.getElementById('participantes').dataset.id = linha.dataset.id;
    if (document.getElementById('j_membros').classList.contains('aberto')) {
        document.getElementById('j_membros').classList.remove('aberto');
        document.getElementById('j_membros').classList.add('fechado');
    }
}

function posiciona_combo(mouse_top) {
    var top = document.getElementById('participantes').offsetHeight + document.getElementById('participantes').offsetTop;
    var left = document.getElementById('participantes').offsetLeft;
    var height = document.getElementById('j_membros').offsetHeight;
    var tam_height = (height + top) - document.body.scrollTop;
    if (tam_height > document.body.offsetHeight) {
        document.body.scrollTop = (top + height) - document.body.offsetHeight;
        top = top - document.body.scrollTop;
        document.getElementById('j_membros').style.top = top + 'px';
    } else {
        top = top - document.body.scrollTop;
        document.getElementById('j_membros').style.top = top + 'px';
    }
    document.getElementById('j_membros').style.width = document.getElementById('participantes').offsetWidth + 'px';
    document.getElementById('j_membros').style.left = left + 'px';
}

function filtra(e) {
    var t = document.querySelector("#detalhes_grid table tbody");
    full_text(e, t, document.getElementById("participantes"), 1);
    if (eval(document.getElementById("participantes").value.length % 1) == 0 || e.keyCode == 13) {
        if (!document.getElementById("participantes").value) {
            combo.classList.remove('aberto');
            return;
        }
        setTimeout(function () {
            posiciona_combo(0);
        }, 100);
        combo.classList.add('aberto');
    }
}

function salvaRelacionamento() {
    try {
        formulario.valida(f);
        tipo_relacionamento_id = document.getElementById('tipo_relacionamento').value;
        parente_id = document.getElementById('participantes').dataset.id;
        parente_base_id = document.getElementById('id').value;
        var strpar = query_string({
            'tipo_relacionamento_id': tipo_relacionamento_id,
            'parente_id': parente_id,
            'parente_base_id': parente_base_id
        });
        ajax('salva_relacionamento.php', strpar, function (json) {
            try {
                var r = JSON.parse(json);
                if (!r.erro) {
                    alerta.sucesso('Parentesco salvo com sucesso', 5);
                    adicionaLinha(r.id, 'ctn_parentesco');
                    limpaCampos();
                } else {
                    throw r.mensagem;
                }
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function adicionaLinha(id, ctn) {
    try {
        var tp_rel = document.getElementById('tipo_relacionamento');
        var nome_rel = document.getElementById('participantes');
        var t_campo = '';
        if (tp_rel.selectedIndex != -1) {
            t_campo = tp_rel.options[tp_rel.selectedIndex].text;
        }
        var a_ctn = ctn.replace('ctn', 'a');
        document.getElementById(ctn).insertAdjacentHTML('beforeend',
            '<div class="' + a_ctn + '">' +
            '  <a class="acao excluir" title="Excluir parentesco" onclick="remover(this)" data-id="' + id + '" data-tipo_relacionamento_id="' + tipo_relacionamento_id + '"' +
            ' data-parente_id="' + parente_id + '" data-parente_base_id="' + parente_base_id + '"></a>' +
            '  <label>' + t_campo + ' de ' + nome_rel.value + '</label>' +
            '</div>');
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function remove(campo) {
    try{
        var strpar = query_string({
            'id': campo.dataset.id,
            'tipo_relacionamento_id': campo.dataset.tipo_relacionamento_id,
            'parente_id': campo.dataset.parente_id,
            'parente_base_id': campo.dataset.parente_base_id
        });
        ajax('exclui_relacionamento.php', strpar, function (json) {
            try{
                var r = JSON.parse(json);
                if(!r.erro){
                    alerta.sucesso(r.mensagem, 5);
                    removerCampo(campo);
                }else{
                    throw r.mensagem;
                }
            }catch (e){
                alerta.erro(e, 5);
            }
        });
    }catch (e){
        alerta.erro(e, 5);
    }
}

function removerCampo(campo) {
    var node = campo.parentNode;
    var p = node.parentNode;
    if (p) {
        p.removeChild(node);
    }
}

function voltar() {
    window.history.back();
}

var tipo_relacionamento_id = '';
var parente_id = '';
var parente_base_id = '';
var f = document.querySelector(".campos");
var combo = document.getElementById('j_membros');
var container = document.body.querySelector('.container');
container.addEventListener('wheel', function (event) {
    if (combo.classList.contains('aberto')) {
        combo.classList.remove('aberto');
    }
});