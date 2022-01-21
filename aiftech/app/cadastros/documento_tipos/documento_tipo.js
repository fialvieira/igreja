function salvaArquivo(campo) {
    try {
        var arquivo = document.getElementById('ctn_doc').querySelector('.a_arquivo:last-child');
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
    var TAMANHO_MAXIMO = 500;
    try {
        document.body.style.cursor = 'progress';
        if (campo.files.length) {
            var file = campo.files[0];
            var tamanho = Math.round(file.size / 1024);
            var extensao = file.type;

            if (tamanho > TAMANHO_MAXIMO) {
                throw 'Arquivo muito grande: ' + tamanho + ' KB. Máximo permitido: ' + TAMANHO_MAXIMO + ' KB.';
            }

            if (extensao != 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                throw 'Permitido apenas arquivo do tipo PDF.';
            }
            var nome = file.name;
            var container = document.getElementById('ctn_doc');
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
    var label = document.body.querySelector('.arquivo .rotulo_arq');
    if (label.classList.contains('oculto')) {
        label.classList.remove('oculto');
    }
}

function excluirArquivo() {
    try {
        var lista_arquivos = document.getElementById('ctn_doc').querySelectorAll('.a_arquivo a.excluido');
        var arquivo = document.getElementById('ctn_doc').querySelector('div.a_arquivo a[href]:not(.excluido)');
        for (var i = 0; i < lista_arquivos.length; i++) {
            if (arquivo && arquivo.dataset.path === lista_arquivos[i].dataset.path) {
//                console.log(lista_arquivos[i].dataset.path);
//                console.log(arquivo.dataset.path);
                continue;
            }
            var params = query_string({
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

function query_string_elementos(elementos) {
    var dic = {};
    for (var i = 0; i < elementos.length; i++) {
        if (elementos[i].type != 'checkbox' && elementos[i].type != 'radio' || elementos[i].checked) {
            dic[elementos[i].name || elementos[i].id] = elementos[i].value;
        }
    }
    return query_string(dic);
}

function salva() {
    try {
        document.getElementById('salvar').classList.add('oculto');
        formulario.valida(f);
        var arquivo = document.getElementById('ctn_doc').querySelector('div.a_arquivo a[href]:not(.excluido)');

        var params = query_string_elementos(f.querySelectorAll('input, select, textarea'));
        if (arquivo) {
            params += ' &path_modelo=' + arquivo.dataset.path;
        }

        ajax("salva.php", params, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);

                excluirArquivo();
                setTimeout(function () {
                    voltar();
                }, 1000);
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
        document.getElementById('salvar').classList.remove('oculto');
    }
}

function voltar() {
    window.history.back();
}

var f = document.querySelector(".campos");