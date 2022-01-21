function pesquisa() {
    try {
        var strpar = montaParametros(f);
        alerta.info('Gerando relatório...', 8);
        window.open('membro.php?' + strpar, '_self');
    } catch (e) {
        alerta.erro(e, 8);
    }
}

function montaParametros(campos) {
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
    return params;
}

var f = document.querySelector(".qbe");