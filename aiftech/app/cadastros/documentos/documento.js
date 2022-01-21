function filtra(e) {
    const t = document.getElementById('j_membros').querySelector("table tbody");
    full_text(e, t, document.getElementById("membros"), 1);
}

function adiciona_participante(linha) {
    try {
        const container = document.getElementById('ctn_membros');
        const id = container.querySelector('.a_membro a[data-id="' + linha.cells[0].dataset.id + '"]');
        if (id) {
            throw 'Membro ' + linha.cells[0].innerHTML + ' já selecionado.';
        }

        container.insertAdjacentHTML('beforeend',
                '<div class="a_membro">' +
                '  <a class="acao excluir" title="Remover o membro." onclick="remove_membro(this)"></a>' +
                '  <a data-id="' + linha.cells[0].dataset.id + '">' +
                linha.cells[0].innerHTML +
                '  </a>' +
                '</div>');
        document.getElementById('membros').value = '';
        combo.fecha();
    } catch (e) {
        alerta.erro(e, 6);
    }
}

function remove_membro(a) {
    const node = a.parentNode;
    const pai = node.parentNode;
    pai.removeChild(node);
}

function salva() {
    try {
        document.getElementById('salvar').classList.add('oculto');
        formulario.valida(f);

        const lista_membros = document.getElementById('ctn_membros').querySelectorAll('.a_membro a:not(.excluir)');
        let membros = '';
        let nome_membros = '';
        if (lista_membros.length > 0) {
            for (var i = 0; i < lista_membros.length; i++) {
                membros += ',' + lista_membros[i].dataset.id;
                nome_membros += lista_membros[i].innerHTML + ' ';
            }
        }
        membros = membros.substring(1);

        const arquivo = document.getElementById('ctn_doc').querySelector('div.a_arquivo a[href]:not(.excluido)');
        let path = '';
        if (arquivo) {
            path = arquivo.dataset.path;
        }
        const params = query_string({
            'id': document.getElementById('id').value,
            'data': document.getElementById('data').value,
            'hora': document.getElementById('hora').value,
            'tipo': document.getElementById('tipo').value,
            'tipo_desc': document.getElementById('tipo').options[document.getElementById('tipo').selectedIndex].innerHTML,
            'presidencia': document.getElementById('presidencia').value,
            'membros': membros,
            'nome_membros': nome_membros,
            'secretario': document.getElementById('secretario').value,
            'ata': document.getElementById('ata').value,
            'ata_num': (document.getElementById('ata').value) ? document.getElementById('ata').options[document.getElementById('ata').selectedIndex].dataset.num : '',
            'igreja_destino_id': document.getElementById('igreja_destino').dataset.value,
            'igreja_destino': (document.getElementById('igreja_destino').dataset.value) ? document.getElementById('j_igrejas').querySelector('table td[data-value="' + document.getElementById('igreja_destino').dataset.value + '"]').innerHTML : '',
            'pastor_destino_id': document.getElementById('pastor_destino').dataset.value,
            'pastor_destino': (document.getElementById('pastor_destino').dataset.value) ? document.getElementById('j_pastores').querySelector('table td[data-value="' + document.getElementById('pastor_destino').dataset.value + '"]').innerHTML : '',
            'data_carta': document.getElementById('data_carta').value,
//            'extensao': document.getElementById('extensao').value,
            'path_arquivo': path
        });
        ajax("salva.php", params, function (resp) {
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                document.getElementById("id").value = r.doc;
                document.getElementById("num").value = r.num;
                excluirArquivo();
                document.getElementById('salvar').classList.remove('oculto');
                document.getElementById('imprimir').classList.remove('oculto');
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

function salvaArquivo(campo) {
    try {
        const arquivo = document.getElementById('ctn_doc').querySelector('.a_arquivo:last-child');
        const pai = arquivo.parentNode;
        const data = new FormData();
        data.append('arquivo', document.getElementById(campo).files[0]);
        ajax("salvaArquivo.php", data, function (resp) {
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                const arq = arquivo.querySelector('a[href]');
                const controle = arquivo.parentNode.parentNode;
                const label_file = document.body.querySelector('.arquivo .rotulo_arq');

                arq.setAttribute('href', 'downloadArquivo.php?dir=' + r.dir);
                arq.dataset.path = r.dir;
                arq.innerHTML = r.nome;
                arquivo.classList.remove('oculto');
                label_file.classList.add('oculto');
                alerta.sucesso('Arquivo anexado com sucesso.', 4);
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
    const TAMANHO_MAXIMO = 2048;
    try {
        document.body.style.cursor = 'progress';
        if (campo.files.length) {
            const container = document.getElementById('ctn_doc');
            let nome;
            let tamanho;
            let extensao;

            const file = campo.files[0];
            nome = file.name;
            tamanho = Math.round(file.size / 1024);
            extensao = file.type;
            if (tamanho > TAMANHO_MAXIMO) {
                throw 'Arquivo ' + nome + ' muito grande: ' + tamanho + ' KB. Máximo permitido: ' + TAMANHO_MAXIMO + ' KB.';
            }
            if (extensao != 'application/pdf' /*&&
             extensao != 'application/vnd.oasis.opendocument.text' &&
             extensao != 'text/html'*/) {
//        throw 'Permitido apenas arquivo do tipo DOCX, PDF, HTML ou ODT.';
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
            salvaArquivo(campo.id);
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
    const label_file = document.body.querySelector('.arquivo .rotulo_arq');
    if (label_file.classList.contains('oculto')) {
        label_file.classList.remove('oculto');
    }
}

function excluirArquivo() {
    try {
        const lista_arquivos = document.getElementById('ctn_doc').querySelectorAll('.a_arquivo a.excluido');
        for (var i = 0; i < lista_arquivos.length; i++) {
            node = lista_arquivos[i].parentNode;
            const params = query_string({
                'dir': lista_arquivos[i].dataset.path
            });
            ajax("excluiArquivo.php", params, function (resp) {
                try {
                    const r = JSON.parse(resp);
                    if (r.erro) {
                        throw r.mensagem;
                    }
                    const pai = node.parentNode;
                    pai.removeChild(node);
                } catch (e) {
                    alerta.erro(e, 10);
                }
            });
        }
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function imprime() {
    try {
        const id = document.getElementById('id').value;
        const individual = document.getElementById('tipo').options[document.getElementById('tipo').selectedIndex].dataset.individual;
        const lista_membros = document.getElementById('ctn_membros').querySelectorAll('.a_membro a:not(.excluir)');
        if (lista_membros.length == 0) {
            throw 'Obrigatório ter pelo menos 01(hum) membro inserido.';
        }
        if (individual == '') {
            throw 'Não encontrado o arquivo modelo do tipo de Documento informado, verifique no Cadastro de Tipos de Documento se é possível fazer o download do arquivo modelo.';
        }
        if (individual == 'S') {
            const type = (lista_membros.length == 1) ? '_self' : '_blank';
            for (var i = 0; i < lista_membros.length; i++) {
                window.open('imprime.php?id=' + id + '&membro=' + lista_membros[i].dataset.id, type);
            }
        } else {
            let lista_id = '';
            for (var i = 0; i < lista_membros.length; i++) {
                lista_id += ',' + lista_membros[i].dataset.id;
            }
            lista_id = lista_id.substr(1);
            window.open('imprime.php?id=' + id + '&membro=' + lista_id, '_self');
        }
    } catch (e) {
        alerta.erro(e, 10);
    }
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
                document.getElementById("id").value = r.doc;
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
    }
}

const f = document.querySelector(".campos");
combo.registra(document.getElementById('membros'), document.getElementById('j_membros'), filtra, adiciona_participante);
combo.registra(document.getElementById('igreja_destino'), document.getElementById('j_igrejas'));
combo.registra(document.getElementById('pastor_destino'), document.getElementById('j_pastores'));
