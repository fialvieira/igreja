function entra() {
    try {
        formulario.valida(valida_usuario);
        ajax('loga.php', valida_usuario, function (resp) {
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso('Sucesso!');
                window.location = '../index.php';
            } catch (e) {
                alerta.erro(e, 10);
            }
        }, 'post');
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function enter(e, el) {
    if (e.keyCode == 13) {
        if (el === document.getElementById('index_senha')) {
            entra();
        } else {
            validaUsuario(document.getElementById('cpf_senha'), 'nova_senha');
        }
        return false;
    }
}

function enviar() {
    try {
        formulario.valida(reset);
        document.body.style.cursor = 'progress';
        ajax('valida_dados.php', reset, function (json) {
            try {
                modal.fecha();
                document.body.style.cursor = '';
                const r = JSON.parse(json);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso(r.mensagem);
//        window.location = '../index.php';
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function salva() {
    try {
        formulario.valida(f);
        if (document.getElementById('cadastro_senha').value != document.getElementById('cadastro_senha2').value) {
            throw 'Senhas não coincidem.';
        }
        /*console.log(f);*/
        ajax('salva.php', f, function (resp) {
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso('Login salvo com sucesso!', 2);
                setTimeout(function () {
                    modal.fecha();
                }, 2000);
            } catch (e) {
                alerta.erro(e, 5);
            }
        }, 'POST');
        alerta.info('Salvando...');
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function limpaCampos(ctn) {
    const els = ctn.querySelectorAll('input');
    for (var i = 0; i < els.length; i++) {
        els[i].value = '';
    }
}

function abreModal(ctn) {
    limpaCampos(reset);
    modal.abre(ctn, function () {
        if (hash.redefine) {
            delete hash.redefine;
            historico.push(hash);
        }
    });
    const hash = historico.hash();
    hash.redefine = 1;
    historico.push(hash);
}

function cadastra() {
    limpaCampos(f);
    modal.abre('j_cadastro_usuario');
}

function validaUsuario(campo, ctn) {
    const hash = historico.hash();
    const strpar = query_string({
        'cpf': campo.value,
        'senha': hash.novasenha
    });

    if (!ctn) {
        ajax('pesquisa_pessoa_usuario.php', strpar, function (json) {
            try {
                const r = JSON.parse(json);
                if (r.ERRO) {
                    throw r.MSG;
                } else {
                    document.getElementById('nome').value = '';
                    document.getElementById('nome').disabled = false;
                    document.getElementById('email').value = '';
                    document.getElementById('email').disabled = false;
                    document.getElementById('fone_movel').value = '';
                    document.getElementById('fone_movel').disabled = false;
//          document.getElementById('nome').focus();
                    if (r.MEMBROS) {
                        alerta.info(r.MSG, 3);
                        document.getElementById('nome').value = r.NOME;
                        document.getElementById('nome').disabled = true;
                        document.getElementById('email').value = r.EMAIL;
                        document.getElementById('email').disabled = true;
                        document.getElementById('fone_movel').value = r.CELULAR;
                        document.getElementById('fone_movel').disabled = true;
                    }
//          var campos = document.getElementById('card_cadastro_usuario').querySelectorAll('.oculto');
//          for (var i = 0; i < campos.length; i++) {
//            campos[i].classList.remove('oculto');
//            }
                }
            } catch (e) {
                alerta.info(e, 5);
                modal.fecha();
            }
        });
    } else {
        ajax('verifica_usuario.php', strpar, function (json) {
            const div_senha = document.getElementById('nova_senha').parentNode.parentNode;
            const div_senha2 = document.getElementById('nova_senha2').parentNode.parentNode;
            try {
                const r = JSON.parse(json);
                if (r.ERRO) {
                    throw r.MSG;
                } else {
//          alerta.info(r.MSG, 3);
                    div_senha.classList.remove('oculto');
                    document.getElementById('nova_senha').required = true;
                    div_senha2.classList.remove('oculto');
                    document.getElementById('nova_senha2').required = true;
                    document.getElementById('btn_salvar_nova').classList.remove('oculto');
                    document.getElementById('nova_senha').focus();
                }
            } catch (e) {
                alerta.erro(e, 5);
                document.getElementById('cpf_senha').focus();
                div_senha.classList.add('oculto');
                document.getElementById('nova_senha').required = false;
                div_senha2.classList.add('oculto');
                document.getElementById('nova_senha2').required = false;
                document.getElementById('btn_salvar_nova').classList.add('oculto');
            }
        });
    }
}

function salva_senha() {
    try {
        formulario.valida(nova);
        if (document.getElementById('nova_senha').value != document.getElementById('nova_senha2').value) {
            throw 'Senhas não coincidem.';
        }

        ajax('salva_senha.php', nova, function (resp) {
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso('Nova senha salva com sucesso!', 2);
                setTimeout(function () {
                    modal.fecha();
                }, 1000);
            } catch (e) {
                alerta.erro(e, 5);
            }
        }, 'POST');
        alerta.info('Salvando...');
    } catch (e) {
        alerta.erro(e, 5);
    }
}

historico.load(function (hash) {
    if (hash.novasenha) {
        limpaCampos(nova);
        modal.abre('j_nova_senha', function () {
            if (hash.novasenha) {
                delete hash.novasenha;
                historico.push(hash);
//        window.closed;
            }
            const div_senha = document.getElementById('nova_senha').parentNode.parentNode;
            const div_senha2 = document.getElementById('nova_senha2').parentNode.parentNode;
            div_senha.classList.add('oculto');
            document.getElementById('nova_senha').required = false;
            div_senha2.classList.add('oculto');
            document.getElementById('nova_senha2').required = false;
            document.getElementById('btn_salvar_nova').classList.add('oculto');
        });
    }
    if (hash.redefine) {
        modal.abre('j_reset_senha', function () {
            if (hash.redefine) {
                delete hash.redefine;
                historico.push(hash);
            }
        });
    } else {
        modal.fecha();
    }
});

const valida_usuario = document.getElementById('card_valida_usuario').querySelector('.campos');
const reset = document.getElementById('card_reset_senha').querySelector('.campos');
const nova = document.getElementById('card_nova_senha').querySelector('.campos');
const f = document.getElementById('card_cadastro_usuario').querySelector('.campos');

document.getElementById('index_login').focus();