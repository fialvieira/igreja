function mostra_arquivos(id) {
    var strpar = query_string({
        'movimentacao_financeira': id
    });
    ajax('arquivos_movimento.php', strpar, function (html) {
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

function cancelar(a) {
    var tr = a.parentNode.parentNode.parentNode;
    document.getElementById('btn_cancelar').setAttribute('onclick', 'cancela(' + tr.cells[0].innerText + ', ' + tr.dataset.codigo_compra + ')');
    modal.abre('j_cancela', function () {
        var campo = document.getElementById('j_cancela').querySelector('.campos .nao-preenchido');
        var hash = historico.hash();
        delete hash.cancela;
        historico.push(hash);
        if (campo) {
            campo.classList.remove('nao-preenchido');
        }
        document.getElementById('justificativa').value = '';
    });
    var hash = historico.hash();
    hash.cancela = tr.cells[0].innerText;
    historico.push(hash);
}

function cancela(id, codigo_compra) {
    try {
        formulario.valida(document.getElementById('j_cancela').querySelector('.campos'));
        var param = query_string({
            "codigo": id,
            "codigo_compra": codigo_compra,
            "cancela": 'S',
            "justificativa": document.getElementById('justificativa').value
        });
        ajax("gera_pagamentos.php", param, function (html) {
            try {
                document.getElementById('card_tbl_movimentacao').classList.remove('oculto');
                document.getElementById('tbl_movimentacao').innerHTML = html;
                alerta.sucesso('Movimentação financeira cancelada com sucesso.', 5);
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        modal.fecha();
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function carregaDadosNota() {
    try {
        let valor = (document.getElementById('valor_nota').value != '') ? parseFloat(document.getElementById('valor_nota').value) : '';
        let parcelas = (document.getElementById('parcelas_nota').value != '') ? parseInt(document.getElementById('parcelas_nota').value) : '';
        if (valor != '' && parcelas != '') {
            document.getElementById('valor').value = valor / parcelas;
        } else {
            document.getElementById('valor').value = '';
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function salva(tipo) {
    try {
        let f = document.querySelector(".campos");
        switch (tipo) {
            case 'DN':
                f = document.getElementById('dados_nota');
                break;
            case 'MM':
                f = document.getElementById('dados_pagamento');
                break;
        }
        formulario.valida(f);
        var arquivos = [];
        var lista_arquivos = document.getElementById((tipo == 'DN') ? 'ctn_arquivos_notas' : 'ctn_arquivos').querySelectorAll('.a_arquivo a.inserido');
        if (lista_arquivos.length > 0) {
            for (var i = 0; i < lista_arquivos.length; i++) {
                var arquivo = {
                    'path': lista_arquivos[i].dataset.path,
                    'nome': lista_arquivos[i].innerHTML
                };
                arquivos.push(arquivo);
            }
        }
        let data = new FormData();
        if (tipo == 'MM') {
            data.append('tipo', document.getElementById('tipo').value);
            data.append('data', document.getElementById('data').value);
            data.append('descricao', document.getElementById('descricao').value);
            data.append('documento', document.getElementById('documento').value);
            data.append('contribuinte', document.getElementById('contribuinte').dataset.value);
            data.append('conta_financeira', document.getElementById('conta_financeira').value);
            data.append('conta', document.getElementById('conta').value);
            data.append('valor', document.getElementById('valor').value);
            data.append('centro_custo', document.getElementById('centro_custo').value);
            data.append('arquivos', JSON.stringify(arquivos));
        } else if (tipo == 'DN') {
            data.append('codigo', document.getElementById('codigo').value);
            data.append('data_nota', document.getElementById('data_nota').value);
            data.append('numero_nota', document.getElementById('numero_nota').value);
            data.append('valor_nota', document.getElementById('valor_nota').value);
            data.append('parcelas_nota', document.getElementById('parcelas_nota').value);
            data.append('meios_pagamentos', document.getElementById('meios_pagamentos').value);
            data.append('observacao', document.getElementById('observacao').value);
            data.append('arquivo_nota', JSON.stringify(arquivos));
        }
        ajax("salva.php", data, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                /*setTimeout(function () {
                    voltar();
                }, 100);*/
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function gerarPagamentos() {
    try {
        let f = document.getElementById('dados_nota');
        formulario.valida(f);
        let g = document.getElementById('dados_pagamento');
        formulario.valida(g);
        ajax('gera_pagamentos.php', g, function (html) {
            try {
                document.getElementById('card_tbl_movimentacao').classList.remove('oculto');
                document.getElementById('tbl_movimentacao').innerHTML = html;
                alerta.sucesso('Pagamentos gerados com sucesso.', 5);
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

/*function alteraTipo() {
    var options = document.getElementById('conta').querySelectorAll('option');
    var tipo = '';
    document.getElementById('contribuinte').parentNode.parentNode.classList.add('oculto');
    if (document.getElementById('tipo').value == 'E') {
        tipo = 'R';
        document.getElementById('contribuinte').parentNode.parentNode.classList.remove('oculto');
    } else if (document.getElementById('tipo').value == 'S') {
        tipo = 'D';
    }
    document.getElementById('conta').value = '';
    for (var i = 0; i < options.length; i++) {
        if (options[i].dataset.tipo == tipo) {
            options[i].classList.remove('oculto');
        } else {
            options[i].classList.add('oculto');
        }
    }
}*/

function voltar() {
    window.history.back();
}

function selecionaArquivoMovimento(campo) {
    try {
        let TAMANHO_MAXIMO = 2048;
        document.body.style.cursor = 'progress';
        if (campo.files.length) {
            let file = campo.files[0];
            var tamanho = Math.round(file.size / 1024);
            var extensao = file.type;

            if (tamanho > TAMANHO_MAXIMO) {
                throw 'Arquivo muito grande: ' + tamanho + ' KB. Máximo permitido: ' + TAMANHO_MAXIMO + ' KB.';
            }
            if (extensao != 'application/pdf') {
                throw 'Permitido apenas arquivo do tipo PDF.';
            }
            let nome = file.name;
            let tr = campo.parentNode.parentNode.parentNode;

            var data = new FormData();
            data.append('dir', file);
            data.append('codigo', tr.cells[0].innerText);

            ajax("excluiArquivo.php", data, function (json) {
                try {
                    let r = JSON.parse(json);
                    if (r.erro) {
                        throw 'Erro ao excluir arquivo';
                    }
                } catch (e) {
                    alerta.erro(e, 5);
                }
            });


            ajax("salvaArquivo.php", data, function (resp) {
                try {
                    var r = JSON.parse(resp);
                    if (r.erro) {
                        throw r.mensagem;
                    }
                    alerta.sucesso('Arquivo anexado com sucesso.', 4);
                } catch (e) {
                    alerta.erro(e, 10);
                }
                document.body.style.cursor = '';
            });

        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function salvaArquivo(campo, vcontainer) {
    try {
        var arquivo = document.getElementById(vcontainer).querySelector('.a_arquivo:last-child');
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

function seleciona_arquivo(campo, vcontainer) {
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
            let nome = file.name;
            let container = document.getElementById(vcontainer);
            container.insertAdjacentHTML('beforeend',
                    '<div class="a_arquivo oculto">' +
                    '  <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>' +
                    '  <a class="inserido"' +
                    '     href="downloadArquivo.php?dir="' +
                    '     data-path=""' +
                    '     target="_blank"' +
                    '     title="Visualizar Arquivo.">' +
                    nome +
                    '  </a>' +
                    '</div>');
            salvaArquivo(campo.id, vcontainer);
        }
    } catch (e) {
        document.body.style.cursor = '';
        alerta.erro(e, 5);
    }
}

function remove_arquivo(a) {
    let node = a.parentNode;
    let arquivo = node.querySelector('a[href]');
    node.classList.add('excluido');
    arquivo.classList.add('excluido');
    arquivo.classList.remove('inserido');
    excluirArquivo(a);
}

function excluirArquivo(a) {
    try {
        let avo = a.parentNode.parentNode;
        let lista_arquivos = document.getElementById(avo.id).querySelectorAll('.a_arquivo a.excluido');
        for (var i = 0; i < lista_arquivos.length; i++) {
            var params = query_string({
                'codigo': document.getElementById('codigo').value,
                'id': lista_arquivos[i].dataset.id,
                'dir': lista_arquivos[i].dataset.path,
                'tipo': avo.id
            });
            ajax("excluiArquivo.php", params, function (resp) {
                try {
                    var r = JSON.parse(resp);

                    if (r.erro) {
                        throw r.mensagem;
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
carregaDadosNota()
/*alteraTipo();*/
/*combo.registra(document.getElementById('contribuinte'), document.getElementById('j_membros'));*/