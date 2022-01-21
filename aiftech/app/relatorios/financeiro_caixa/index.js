function carregaMeses(campo) {
    try {
        var strpar = query_string({
            'ano': campo.value
        });
        ajax('carrega_meses.php', strpar, function (html) {
            try {
                document.getElementById('mes').innerHTML = html;
            } catch (e) {
                alerta.erro(e, 3);
            }
        })
    } catch (e) {
        alerta.erro(e, 3);
    }
}

function pesquisa() {
    try {
        formulario.valida(f);
        var strpar = query_string({
            'ano': document.getElementById('ano').value,
            'mes': document.getElementById('mes').value,
            'movimentacao': document.getElementById('movimentacao').value,
            'tipo': document.getElementById('tipo').value
        });
        window.open('caixa.php?' + strpar, '_blank');
    } catch (e) {
        alerta.erro(e, 5);
    }
}

var f = document.querySelector('.qbe');