function pesquisa() {
    try {
        formulario.valida(f);
        alerta.info('Gerando relatório em formato xls.');
        ajax('orcamento.php', f, function (ret) {
            try {
                var r = JSON.parse(ret);
                if (r.erro) {
                    throw r.msg;
                }
                alerta.sucesso('Relatório gerado, aguarde a conclusão do download automático do arquivo ' + r.msg + '.xls', 5);
                window.open('imprime.php?ano='+document.getElementById('ano').value, '_self');
            } catch (e) {
                alerta.erro(e, 8);
            }
        });
    } catch (e) {
        alerta.erro(e, 8);
    }
}

var f = document.querySelector('.campos');