function carregaContasFinanceiras(campo) {
    try {
        var strpar = query_string({
            'id': campo.value
        });
        ajax('carrega_contas_financeiras.php', strpar, function (html) {
            try {
                document.getElementById('conta_financeira').innerHTML = html;
            } catch (e) {
                alerta.erro(e, 3);
            }
        });
    } catch (e) {
        alerta.erro(e, 3);
    }
}

function salva() {
    try {
        formulario.valida(f);

        var arquivos = [];
        var lista_arquivos = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo a.inserido');
        if (lista_arquivos.length > 0) {
            for (var i = 0; i < lista_arquivos.length; i++) {
                var arquivo = {
                    'path': lista_arquivos[i].dataset.path,
                    'nome': lista_arquivos[i].innerHTML
                };
                arquivos.push(arquivo);
            }
        }
        var data = new FormData();
        data.append('codigo', document.getElementById('codigo').value);
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


//        var params = query_string({
//            'codigo': document.getElementById('codigo').value,
//            'tipo': document.getElementById('tipo').value,
//            'data': document.getElementById('data').value,
//            'descricao': document.getElementById('descricao').value,
//            'documento': document.getElementById('documento').value,
//            'contribuinte': document.getElementById('contribuinte').dataset.value,
//            'conta_financeira': document.getElementById('conta_financeira').value,
//            'conta': document.getElementById('conta').value,
//            'valor': document.getElementById('valor').value,
//            'centro_custo': document.getElementById('centro_custo').value
//        });
        ajax("salva.php", data, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                excluirArquivo();
                setTimeout(function () {
                    voltar();
                }, 100);
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function alteraTipo() {
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
}

function voltar() {
    window.history.back();
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
//            if (campo == 'arquivo_ata') {
//                var label = document.querySelector('label.file[for="' + campo + '"]');
//                label.classList.add('oculto');
//            }
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
            salvaArquivo(campo.id);
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
}

function excluirArquivo() {
    try {
        var lista_arquivos = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo a.excluido');

        for (var i = 0; i < lista_arquivos.length; i++) {
            var params = query_string({
                'movimentacao_financeira': document.getElementById('codigo').value,
                'id': lista_arquivos[i].dataset.id,
                'dir': lista_arquivos[i].dataset.path
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

var f = document.querySelector(".campos");
alteraTipo();
combo.registra(document.getElementById('contribuinte'), document.getElementById('j_membros'));
