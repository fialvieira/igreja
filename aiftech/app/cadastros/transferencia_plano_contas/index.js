function filtra() {
    var hash = historico.hash();
    var linhas = document.querySelectorAll(".container-grid .grid table tbody tr");
    var cab = document.querySelector(".container-grid .grid table thead tr");
    if (!document.getElementById("categoria").value) {
        delete hash.filtra;
        cab.classList.add('oculto');
    } else {
        hash.filtra = document.getElementById("categoria").value;
        cab.classList.remove('oculto');
    }
    historico.push(hash);

    for (var i = 0; i < linhas.length; i++) {
        if (linhas[i].dataset.categoria == document.getElementById("categoria").value) {
            linhas[i].classList.remove('oculto');
        } else {
            linhas[i].classList.add('oculto');
        }
    }
}

function salvar() {
    try {
        if (!document.getElementById('categoria').value) {
            throw 'Obrigatório informar um Plano de Conta';
        }
        modal.abre('j_salva', function () {
            var hash = historico.hash();
            delete hash.salva;
            historico.push(hash);
        });
        var hash = historico.hash();
        hash.salva = 1;
        historico.push(hash);
    } catch (e) {
        alerta.erro(e, 4);
    }
}

function salva() {
    try {
        var linhas = document.querySelectorAll('.container-grid .grid table tbody tr:not(.oculto) .cat_filhas');
        var lancamentos = [];
        for (var i = 0; i < linhas.length; i++) {
            if (linhas[i].value != '') {
                var reg = {
                    'codigo': linhas[i].dataset.movimentacao,
                    'categoria': linhas[i].value
                };
                lancamentos.push(reg);
            }
        }

        if (lancamentos.length == 0) {
            throw 'Obrigatório realizar pelo menos uma transferência.';
        }
        var param = query_string({
            'lancamentos': JSON.stringify(lancamentos)
        });
        ajax("salva.php", param, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso('Salvo com sucesso.', 3);
//                filtra();
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } catch (e) {
                alerta.erro(e, 10);
            }
        }, 'POST');
        modal.fecha();
    } catch (e) {
        modal.fecha();
        alerta.erro(e, 10);
    }
}

historico.load(function (hash) {
    if (hash.filtra) {
        document.getElementById("categoria").value = hash.filtra;
        delete hash.filtra;
        historico.push(hash);
        filtra();
    } else {
        document.getElementById("categoria").value = "";
        filtra();
    }

    if (hash.salva) {
//        document.getElementById('btn_salvar').setAttribute('onclick', 'salva(' + hash.salva + ')');
        modal.abre('j_salva', function () {
            var hash = historico.hash();
            delete hash.salva;
            historico.push(hash);
        });
    } else {
        modal.fecha();
    }
});

//pesquisa();