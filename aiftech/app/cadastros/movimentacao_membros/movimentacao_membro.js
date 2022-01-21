function setDataRecebimento(campo) {
    var strpar = query_string({
        'id': campo.value
    });
    ajax('set_data_recebimento.php', strpar, function (json) {
        var r = JSON.parse(json);
        if (r != '') {
            document.getElementById('data_recebimento').value = r;
        }
    })
}

function salvaArquivo(campo) {
    try {
        var arquivo = document.getElementById('ctn_arquivos').querySelector('.a_arquivo:last-child');
        var pai = arquivo.parentNode;

        var data = new FormData();
        data.append('arquivo', document.getElementById(campo).files[0]);

        ajax("salvaArquivo.php", data, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso('Arquivo anexado com sucesso.', 4);
                var arq = arquivo.querySelector('a[href]');
                arq.setAttribute('href', 'downloadArquivo.php?dir=' + r.dir);
                arq.dataset.path = r.dir;
                arq.innerHTML = r.nome;
                arquivo.classList.remove('oculto');
            } catch (e) {
                pai.removeChild(arquivo);
                alerta.erro(e, 10);
            }
            document.body.style.cursor = '';
        });
    } catch (e) {
        pai.removeChild(arquivo);
        document.body.style.cursor = '';
        alerta.erro(e, 10);
    }
}

function seleciona_arquivo(campo) {
    var TAMANHO_MAXIMO = 2048;
    try {
        document.body.style.cursor = 'progress';
        if (campo.files.length) {
            var file = campo.files[0];
            var tamanho = Math.round(file.size / 1024);
            var extensao = file.type;
            if (tamanho > TAMANHO_MAXIMO) {
                throw 'Arquivo muito grande: ' + tamanho + ' KB. Máximo permitido: ' + TAMANHO_MAXIMO + ' KB.';
            }
            if (extensao != 'application/pdf') {
                throw 'Permitido apenas arquivo do tipo PDF.';
            }
            var nome = file.name;
            var container;

            container = document.getElementById('ctn_arquivos');

            container.insertAdjacentHTML('beforeend',
                '<div class="a_arquivo">' +
                '  <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>' +
                '  <a class="inserido"' +
                '     href="downloadArquivo.php?dir="' +
                '     data-path=""' +
                '     target="_blank"' +
                '     title="Visualizar Arquivo.">' +
                nome +
                '  </a>' +
                '</div>');
            salvaArquivo(campo.id);
            document.getElementById('arquivo').disabled = true;
        }
    } catch (e) {
        document.body.style.cursor = '';
        alerta.erro(e, 5);
    }
}

function remove_arquivo(a) {
    var node = a.parentNode;
    var arquivo = node.querySelector('a[href]');
    node.classList.add('excluido');
    arquivo.classList.add('excluido');
    arquivo.classList.remove('inserido');
    excluirArquivo();
}

function excluirArquivo() {
    try {
        var lista_arquivos = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo a.excluido');
        for (var i = 0; i < lista_arquivos.length; i++) {
            var params = query_string({
                'path': lista_arquivos[i].dataset.path
            });
            ajax("exclui_arquivo.php", params, function (resp) {
                try {
                    var r = JSON.parse(resp);
                    if (r.erro) {
                        throw r.mensagem;
                    } else {
                        alerta.sucesso(r.mensagem, 5);
                        document.getElementById('arquivo').disabled = false;
                    }
                } catch (e) {
                    alerta.erro(e, 10);
                }
            });
        }
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function excluirArquivoParametro(path) {
    try {
        var params = query_string({
            'path': path
        });
        ajax("exclui_arquivo.php", params, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                } else {
                    alerta.sucesso(r.mensagem, 5);
                    document.getElementById('arquivo').disabled = false;
                }
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function adicionaMovimentacao(id) {
    try {
        var strpar = query_string({
            'id': id
        });
        document.getElementById('grid').innerHTML = templates.CARREGANDO;
        ajax('pesquisa.php', strpar, function (html) {
            document.getElementById('grid').innerHTML = html;
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function remover(campo) {
    var tr = campo.parentNode.parentNode.parentNode;
    var tbody = tr.parentNode;
    if (tbody) {
        tbody.removeChild(tr);
    }
}

function limpaCampos() {
    ajustar = false;
    var inputs = document.querySelectorAll('input');
    var selects = document.querySelectorAll('select');
    var txarea = document.querySelectorAll('textarea');
    if (inputs != null && inputs.length != 0) {
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type != 'hidden') {
                inputs[i].value = '';
            }
        }
    }
    if (selects != null && selects.length != 0) {
        for (var i = 0; i < selects.length; i++) {
            selects[i].value = -1;
        }
    }
    if (txarea != null && txarea.length != 0) {
        for (var i = 0; i < txarea.length; i++) {
            txarea[i].value = '';
        }
    }
    document.getElementById('ctn_arquivos').innerHTML = '';
    document.getElementById('arquivo').disabled = false;
}

function excluir(campo, id) {
    try {
        var linha = campo.parentNode.parentNode.parentNode;
        var path = linha.cells[7].dataset.path;
        var strpar = query_string({
            'id': id
        });
        ajax('excluir.php', strpar, function (json) {
            try {
                var r = JSON.parse(json);
                if (r.erro) {
                    throw r.mensagem;
                } else {
                    alerta.sucesso(r.mensagem, 5);
                    if (path != '') {
                        excluirArquivoParametro(path);
                    }
                    remover(campo);
                }
            } catch (e) {
                alerta.erro(e, 5);
            }
        })
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function salva(id) {
    try {
        formulario.valida(f);
        if (!verificaCamposPreenchidos()) {
            throw 'Pelo menos um campo deve ser preenchido';
        }
        var strpar = montaParametros();
        ajax("salva.php", strpar, function (resp) {
            try {
                var r = JSON.parse(resp);
                console.log(r);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo", 5);
                adicionaMovimentacao(id);
                limpaCampos();
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function verificaCamposPreenchidos() {
    var inputs = document.querySelectorAll('input:not([type="hidden"])');
    var selects = document.querySelectorAll('select');
    var txarea = document.querySelectorAll('textarea');

    if (inputs != null && inputs.length != 0) {
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].value != '') {
                console.log(inputs[i]);
                return true;
            }
        }
    }
    if (selects != null && selects.length != 0) {
        for (var i = 0; i < selects.length; i++) {
            if (selects[i].value != '') {
                console.log(selects[i]);
                return true;
            }
        }
    }
    if (txarea != null && txarea.length != 0) {
        for (var i = 0; i < txarea.length; i++) {
            if (txarea[i].value != '') {
                console.log(txarea[i]);
                return true;
            }
        }
    }
    return false;
}

function montaParametros() {
    var ctn_arquivos = document.getElementById('ctn_arquivos');
    var arquivo_inserido = (ctn_arquivos.querySelector('a.inserido')) ? ctn_arquivos.querySelector('a.inserido') : '';
    var strpar = query_string({
        'membro_id': document.getElementById('membro_id').value,
        'ata': document.getElementById('ata').value,
        'carta': document.getElementById('carta').value,
        'tipo_movimentacao': document.getElementById('tipo_movimentacao').value,
        'data_recebimento': document.getElementById('data_recebimento').value,
        'observacao': document.getElementById('observacao').value,
        'arquivo_path': (arquivo_inserido != '' ) ? arquivo_inserido.dataset.path : ''
    });
    return strpar;
}

function voltar() {
    window.history.back();
}

var membro_id = localStorage.getItem('membro_id');
var f = document.querySelector('.card');
if (membro_id != '' && membro_id != undefined) {
    adicionaMovimentacao(membro_id);
}