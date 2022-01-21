function salva() {
    try {
        formulario.valida(f);
        var params = montaParametros();
        ajax("salva.php", params, function (resp) {
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

function montaParametros(){
    gravaDepartamentos();
    var params = query_string({
        'id': document.getElementById('id').value,
        'nome': document.getElementById('nome').value,
        'abreviacao': document.getElementById('abreviacao').value,
        'descricao': document.getElementById('descricao').value,
        'tipo_comissao': document.getElementById('tipo_comissao').value,
        'departamentos': deps
    });
    return params;
}

function voltar() {
    window.history.back();
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

function adicionaDepartamento(campo) {
    var v_campo = campo.value;
    var t_campo = '';
    if (campo.selectedIndex != -1) {
        t_campo = campo.options[campo.selectedIndex].text;
    }
    if (valida(v_campo, document.getElementById('ctn_departamentos'))) {
        document.getElementById('ctn_departamentos').insertAdjacentHTML('beforeend',
            '<div class="a_cargo_dep">' +
            '  <a class="acao excluir" onclick="remover(this)" data-id="' + v_campo + '"></a>' +
            '  <label>' + t_campo + '</label>' +
            '</div>');
    }
}

function remover(campo) {
    var node = campo.parentNode;
    var p = node.parentNode;
    if (p) {
        p.removeChild(node);
    }
}

function gravaDepartamentos() {
    var a_deps = document.getElementById('ctn_departamentos').querySelectorAll('a');
    for (var i = 0; i < a_deps.length; i++) {
        deps[i] = a_deps[i].getAttribute('data-id');
    }
}

var f = document.querySelector(".campos");
var deps = new Array();