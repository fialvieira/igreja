function mudarStatus(id, acao) {
    var par = query_string({
        'codigo': id,
        'acao': acao
    });
    ajax('usuario_excluir.php', par, function (resp) {
        try {
            var r = JSON.parse(resp);
            if (r.erro) {
                throw r.mensagem;
            }
            alerta.sucesso(r.mensagem, 2);
            pesquisa();
        } catch (e) {
            alerta.erro(e, 5);
        }
    });
    alerta.info('Alterando status...');
}

function pesquisa(tipo) {
    try {
        var grid = document.querySelector('.container-grid .grid');
        function retorno(html) {
            try {
                grid.innerHTML = html;
                var tr = grid.querySelectorAll('table tbody tr');
                if (tr.length == 0) {
                    grid.innerHTML = '';
                    throw 'Nenhum registro encontrado';
                }
                if (tr.length > 0 && tr.length < 2) {
                    document.getElementById('total_registros').innerHTML = tr.length + ' registro encontrados';
                } else {
                    document.getElementById('total_registros').innerHTML = tr.length + ' registros encontrados';
                }
                var hash = historico.hash();
                hash.pesquisa = document.getElementById('pesquisa_ftxt').value;
                historico.push(hash);
            } catch (e) {
                alerta.erro(e, 8);
            }
        }
        if (tipo != 'ft') {
            parametros = query_string({
                'usuario': '',
                'status': ''
            });
        } else {
            parametros = query_string({
                'usuario': document.getElementById('pesquisa_ftxt').value,
                'status': (document.getElementById('sel_status')) ? document.getElementById('sel_status').value : ''
            });
        }
        ajax('pesquisa.php', parametros, retorno);
        grid.innerHTML = templates.CARREGANDO;
        document.getElementById('total_registros').innerHTML = '';
    } catch (e) {
        alerta.erro(e, 8);
    }
}

historico.load(function (hash) {
    if (hash.pesquisa) {
        delete hash.pesquisa;
        historico.push(hash);
        pesquisa();
    }
})

function enter(e) {
    if (e.keyCode == 13) {
        pesquisa('ft');
        return false;
    }
}

pesquisa();



