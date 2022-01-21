function ao_mudar_tipo(campo) {
    if (campo.value) {
        document.getElementById('tx_corpo').value = campo.options[campo.selectedIndex].dataset.padrao;
    } else {
        document.getElementById('tx_corpo').value = '';
    }
    alteraTagTexto();
}

function ao_mudar_presidente(campo) {
    if (campo.value) {
        let texto = document.getElementById('tx_corpo').value;
        texto = texto.replaceAll('#PRESIDENTE', campo.options[campo.selectedIndex].innerHTML);
        document.getElementById('tx_corpo').value = texto;
    }
}

function ao_mudar_secretaria(campo) {
    if (campo.value) {
        let texto = document.getElementById('tx_corpo').value;
        texto = texto.replaceAll('#SECRETARIA', campo.options[campo.selectedIndex].innerHTML);
        document.getElementById('tx_corpo').value = texto;
    }
}

function alteraTagTexto() {
    if (document.getElementById('tx_corpo').value) {
        let texto = document.getElementById('tx_corpo').value;
        texto = texto.replace('#TIPO', document.getElementById('tipo').options[document.getElementById('tipo').selectedIndex].innerHTML);
        texto = texto.replace('#IGREJA', igreja);
        const arrayData = document.getElementById('data').value.split('/');
        const dt_extenso = arrayData[0].extenso() + ' de ' +
                DataHora.mesExtenso(arrayData[1]).toLowerCase() + ' de ' + arrayData[2].extenso();
        texto = texto.replace('#DATA_EXTENSO', dt_extenso);
        texto = texto.replace('#DATA', document.getElementById('data').value);
        texto = texto.replace('#ENDERECO', endereco);

        document.getElementById('tx_corpo').value = texto;
    }
}

function filtra(e) {
    const t = document.getElementById('j_membros').querySelector("table tbody");
    full_text(e, t, document.getElementById('participantes'), 1);
}

function adiciona_participante(linha) {
    try {
        const array = JSON.parse(linha.dataset.array);
        let texto = '';
        texto = ' ' + linha.cells[0].innerHTML;
        if (array[0].cargo !== null) {
            for (var i = 0; i < array.length; i++) {
                texto += ', ' + array[i].cargo + ', ' + array[i].departamento;
            }
        }
        texto += ';';

        ultimo_campo_tx.value = ultimo_campo_tx.value.substring(0, cursor_posicao) + texto + ultimo_campo_tx.value.substring(cursor_posicao);
        document.getElementById('participantes').value = '';
        combo.fecha();
        ultimo_campo_tx.focus();
        ultimo_campo_tx.selectionEnd = cursor_posicao + texto.length;
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function salva() {
    try {
        document.getElementById('salvar').classList.add('oculto');
        formulario.valida(f);

        if (trim(document.getElementById('tx_corpo').value) == '') {
            throw 'Obrigatório preencher o campo "Texto".';
        }

        let arquivos = [];
        const lista_ata = document.getElementById('ctn_ata').querySelectorAll('.a_arquivo a.inserido');
        if (lista_ata.length > 0) {
            for (var i = 0; i < lista_ata.length; i++) {
                const arquivo = {
                    'path': lista_ata[i].dataset.path,
                    'nome': lista_ata[i].innerHTML,
                    'ata_digit': 'S'
                };
                arquivos.push(arquivo);
            }
        }
        const lista_arquivos = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo a.inserido');
        if (lista_arquivos.length > 0) {
            for (var i = 0; i < lista_arquivos.length; i++) {
                const arquivo = {
                    'path': lista_arquivos[i].dataset.path,
                    'nome': lista_arquivos[i].innerHTML,
                    'ata_digit': ''
                };
                arquivos.push(arquivo);
            }
        }
        const data = new FormData();
        data.append('id', document.getElementById('id').value);
        data.append('data', document.getElementById('data').value);
        data.append('tipo', document.getElementById('tipo').value);
        data.append('presidencia', document.getElementById('presidencia').value);
        data.append('tx_corpo', document.getElementById('tx_corpo').value);
        data.append('secretario', document.getElementById('secretario').value);
        data.append('arquivos', JSON.stringify(arquivos));

        ajax("salva.php", data, function (resp) {
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                document.getElementById("id").value = r.ata;
                document.getElementById("num").value = r.num;
                excluirArquivo();
                if (r.finalizado != 'S') {
                    document.getElementById('salvar').classList.remove('oculto');
                } else {
                    setTimeout(function () {
                        voltar();
                    }, 1000);
                }
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

function salvaArquivo(campo, indice) {
    try {
        const arquivo = (campo == 'arquivo_ata') ? document.getElementById('ctn_ata').querySelector('.a_arquivo:last-child') :
                document.getElementById('ctn_arquivos').querySelector('.a_arquivo:last-child');
        const pai = arquivo.parentNode;

        const data = new FormData();
        data.append('arquivo', document.getElementById(campo).files[indice]);

        ajax("salvaArquivo.php", data, function (resp) {
            document.body.style.cursor = '';
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }

                const arq = arquivo.querySelector('a[href]');
                arq.setAttribute('href', 'downloadArquivo.php?dir=' + r.dir);
                arq.dataset.path = r.dir;
                arq.innerHTML = r.nome;
                arquivo.classList.remove('oculto');
                if (campo == 'arquivo_ata') {
                    const label = document.querySelector('label.file[for="' + campo + '"]');
                    label.classList.add('oculto');
                }
            } catch (e) {
                pai.removeChild(arquivo);
                alerta.erro(e, 10);
            }
        });
    } catch (e) {
        pai.removeChild(arquivo);
        document.body.style.cursor = '';
        alerta.erro(e, 10);
    }
}

function seleciona_arquivo(campo) {
    const TAMANHO_MAXIMO = 2048;
    try {
        document.body.style.cursor = 'progress';

        if (campo.files.length) {
            let container;
            let nome;
            let tamanho;
            let extensao;

            if (campo.id == 'arquivo_ata') {
                container = document.getElementById('ctn_ata');
            } else {
                container = document.getElementById('ctn_arquivos');
            }

            for (var i = 0; i < campo.files.length; i++) {
                const file = campo.files[i];
                nome = file.name;
                tamanho = Math.round(file.size / 1024);
                extensao = file.type;
                if (tamanho > TAMANHO_MAXIMO) {
                    throw 'Arquivo ' + nome + ' muito grande: ' + tamanho + ' KB. Máximo permitido: ' + TAMANHO_MAXIMO + ' KB.';
                }
                if (extensao != 'application/pdf') {
                    throw 'Arquivo ' + nome + ' inválido. Permitido apenas arquivo do tipo PDF.';
                }
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
                salvaArquivo(campo.id, i);
            }

            alerta.sucesso('Arquivo(s) anexado(s) com sucesso.', 4);
        }
    } catch (e) {
        document.body.style.cursor = '';
        alerta.erro(e, 10);
    }
}

function remove_arquivo(a) {
    const node = a.parentNode;
    const arquivo = node.querySelector('a[href]');
    node.classList.add('excluido');
    arquivo.classList.add('excluido');
    arquivo.classList.remove('inserido');
}

function excluirArquivo() {
    try {
        const lista_arquivos = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo a.excluido');

        for (var i = 0; i < lista_arquivos.length; i++) {
            const params = query_string({
                'ata': document.getElementById('id').value,
                'id': lista_arquivos[i].dataset.id,
                'dir': lista_arquivos[i].dataset.path
            });
            ajax("excluiArquivo.php", params, function (resp) {
                try {
                    const r = JSON.parse(resp);

                    if (r.erro) {
                        throw r.mensagem;
                    }
                } catch (e) {
                    alerta.erro(e, 10);
                }
            });
            let arquivo = lista_arquivos[i].parentNode;
            let container = arquivo.parentNode;
            container.removeChild(arquivo);
        }
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function setUltimoCampoTx(campo) {
    ultimo_campo_tx = campo;
    cursor_posicao = campo.selectionStart;
}

function voltar() {
    window.history.back();
}

function finalizar() {
    modal.abre('j_finalizar', function () {

    });
}

function finaliza() {
    try {
        const params = query_string({
            'id': document.getElementById('id').value,
            'finaliza': 'S'
        });

        ajax("salva.php", params, function (resp) {
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                document.getElementById("id").value = r.ata;
                excluirArquivo();
                setTimeout(function () {
                    voltar();
                }, 1000);
            } catch (e) {
                alerta.erro(e, 10);
            }
        }, 'post');
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

combo.registra(document.getElementById('participantes'), document.getElementById('j_membros'), filtra, adiciona_participante);

const igreja = window.sessionStorage.getItem('igreja');
const endereco = window.sessionStorage.getItem('endereco');
const f = document.querySelector(".campos");
let ultimo_campo_tx = document.getElementById('tx_corpo'),
        cursor_posicao = null;

String.prototype.replaceAll = function (search, replacement) {
    const target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};