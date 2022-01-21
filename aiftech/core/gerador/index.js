function seleciona_todas() {
    var tabelas = document.getElementById('tabelas').querySelectorAll('tr td.acoes div a.seleciona');
    var selecionados = document.getElementById('tabelas').querySelectorAll('tr td.acoes div a.selecionado');

    for (var i = 0; i < tabelas.length; i++) {
        tabelas[i].classList.remove('selecionado');
    }
    if (tabelas.length != selecionados.length) {
        for (var i = 0; i < tabelas.length; i++) {
            tabelas[i].classList.toggle('selecionado');
        }
    }
}

function seleciona_tabela(a) {
    a.classList.toggle('selecionado');
}

function gerar() {
    try {
        if (document.getElementById('tabelas')) {
            var itens = [];
            var tabelas = document.getElementById('tabelas').querySelectorAll('tr td.acoes div a.selecionado');
            for (var i = 0; i < tabelas.length; i++) {
                var serv = {
                    'tabela': tabelas[i].dataset.tabela,
                    'descricao': tabelas[i].dataset.descricao
                };
                itens.push(serv);
            }
        }
        var strpar = query_string({
            'itens': JSON.stringify(itens)
        });

        ajax('cria_arquivos_auto.php', strpar, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso('Gerado.', 3);
            } catch (e) {
                alerta.erro(e, 10);
            }
        }, 'POST');
        alerta.info('Gerando...');
    } catch (e) {
        alerta.erro(e, 10);
    }
}

