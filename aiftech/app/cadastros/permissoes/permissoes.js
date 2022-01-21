function salva() {
    try {
        formulario.valida(f);
        var permissoes = [];
        var itens = document.body.querySelectorAll('.container .permissao');

        for (var i = 0; i < itens.length; i++) {
//            if (itens[i].value != '') {
                var item = {
                    'id': itens[i].dataset.id,
                    'modulo_id': itens[i].dataset.modulo_id,
                    'permissao': itens[i].value
                };
                permissoes.push(item);
//            }
        }

        var params = query_string({
            'user': document.getElementById('user').value,
            'permissoes': JSON.stringify(permissoes)
        });

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

function voltar() {
    window.history.back();
}

var f = document.querySelector(".campos");