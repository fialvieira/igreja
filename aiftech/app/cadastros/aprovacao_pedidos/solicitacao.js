function salva(tipo) {
    try {
        alerta.info("Salvando...");
        document.getElementById('btn_aprovar').classList.add('oculto');
        document.getElementById('btn_recusar').classList.add('oculto');
        let strpar = '';
        if (tipo == 'R') {
            modal.abre('j_observacao', function () {
                if (obs != '') {
                    strpar = query_string({
                        'id': document.getElementById('id').value,
                        'aprova': tipo,
                        'observacao': obs
                    });
                    ajax('aprova.php', strpar, function (json) {
                        try {
                            let r = JSON.parse(json);
                            if (r.erro) {
                                throw r.mensagem;
                            }
                            obs = '';
                            alerta.sucesso("Salvo.", 3);
                            document.getElementById('btn_aprovar').classList.remove('oculto');
                            document.getElementById('btn_recusar').classList.remove('oculto');
                            voltar();
                        } catch (e) {
                            alerta.erro(e, 5);
                        }
                    });
                }
            });
        } else {
            strpar = query_string({
                'aprova': tipo,
                'id': document.getElementById('id').value,
                'solicitante_id': document.getElementById('solicitante').value,
                'observacao': ''
            });
            ajax('aprova.php', strpar, function (json) {
                try {
                    let r = JSON.parse(json);
                    if (r.erro) {
                        throw r.mensagem;
                    }
                    alerta.sucesso("Salvo.", 3);
                    document.getElementById('btn_aprovar').classList.remove('oculto');
                    document.getElementById('btn_recusar').classList.remove('oculto');
                    voltar();
                } catch (e) {
                    alerta.erro(e, 5);
                }
            });
        }
    } catch (e) {
        alerta.erro(e, 10);
        document.getElementById('btn_aprovar').classList.remove('oculto');
        document.getElementById('btn_recusar').classList.remove('oculto');
    }
}

function salvaObservacao(id) {
    try {
        let campo = document.getElementById(id);
        let div_campo = campo.parentNode.parentNode;
        if (campo.value == '' || String(campo.value).length < 4) {
            div_campo.classList.add('nao-preenchido');
            throw 'O campo não pode estar vazio';
        } else {
            if (div_campo.classList.contains('nao-preenchido')) {
                div_campo.classList.remove('nao-preenchido');
            }
            obs = campo.value;
            modal.fecha();
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function carregaItens(dispositivo) {
    try {
        let params = query_string({
            'compra': document.getElementById('id').value,
            'dispositivo': dispositivo,
            'situacao': document.getElementById('situacao').value
        });
        document.getElementById('ctn_itens').innerHTML = '';
        ajax("itens.php", params, function (html) {
            document.getElementById('ctn_itens').innerHTML = html;
        });
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function carregaOrcamentos(dispositivo) {
    try {
        let params = query_string({
            'compra': document.getElementById('id').value,
            'dispositivo': dispositivo,
            'situacao': document.getElementById('situacao').value
        });
        document.getElementById('ctn_orcamentos').innerHTML = '';
        ajax("orcamentos.php", params, function (html) {
            try {
                document.getElementById('ctn_orcamentos').innerHTML = html;
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function voltar() {
    window.history.back();
}

let f = document.querySelector(".campos");
let obs = '';

if (document.getElementById('produto')) {
    combo.registra(document.getElementById('produto'), document.getElementById('j_produtos'), filtra, adiciona_produto);
}

if (window.matchMedia("(min-width: 768px)").matches) {
    carregaItens(''); //--> demais dispositivos (tablet, desktop)
    carregaOrcamentos('');
} else {
    carregaItens('S'); //--> (S)martphone
    carregaOrcamentos('S');
}