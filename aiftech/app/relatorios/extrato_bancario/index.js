function mostra_arquivos(id) {
    var strpar = query_string({
        'movimentacao_financeira': id
    });
    ajax('arquivos.php', strpar, function (html) {
        if (html) {
            document.getElementById('detalhes_grid').innerHTML = html;
            var hash = historico.hash();
            hash.arquivos = '1';
            historico.push(hash);
            modal.abre('j_arquivos', function () {
                var hash = historico.hash();
                delete hash.arquivos;
                historico.push(hash);
            });
        } else {
            alerta.info('Este lançamento não possui arquivos anexos.', 3);
        }
    });
}

function carregaContas(campo) {
    try {
        var contas = document.getElementById('conta').querySelectorAll('option');
        for (var i = 1; i < contas.length; i++) {
            contas[i].classList.remove('oculto');
            if (campo.value && contas[i].dataset.banco != campo.value) {
                contas[i].classList.add('oculto');
            }
        }
    } catch (e) {
        alerta.erro(e, 3);
    }
}

function pesquisa(tipo) {
    try {
        var grid = document.body.querySelector('.grid');
        formulario.valida(f);
        var strpar = query_string({
            'tipo': tipo,
            'banco': document.getElementById('banco').value,
            'conta': document.getElementById('conta').value,
            'periodo': document.getElementById('periodo').value
        });
        if (tipo == 'P') {
            ajax('pesquisa.php', strpar, function (html) {
                try {
                    grid.innerHTML = html;
                    var linhas = grid.querySelectorAll('table tbody tr');
                    if (linhas.length == 0) {
                        grid.innerHTML = '';
                        throw 'Nenhum lançamento encontrado.';
                    }
                    alerta.fecha();
                } catch (e) {
                    alerta.erro(e, 3);
                }
            });
            alerta.info('Gerando Extrato...');
            grid.innerHTML = templates.CARREGANDO;
        } else {
            window.open('pesquisa.php?' + strpar, '_blank');
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

var f = document.querySelector('.qbe');