function carregaFornecedores() {
    try {
        ajax("carregaFornecedores.php", null, function (html) {
            document.body.style.cursor = '';
            try {
                if (!html) {
                    throw 'Não foi possível carregar os fornecedores!';
                }
                lista_fornecedores = html;
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
    } catch (e) {
        document.body.style.cursor = '';
        alerta.erro(e, 10);
    }
}

function carregaOrcamentosItens() {
    try {
        const selects = document.getElementById('ctn_itens').querySelectorAll('table tbody select');
        const orcamentos_label = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo:not(.excluido) label');
        const orcamentos_select = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo:not(.excluido) select');

        if (orcamentos_label.length > 0) { //--> checa se já existia algum orçamento inserido para fazer o carregamentos dos itens
            for (var i = 0; i < selects.length; i++) {
                const linha = selects[i].parentNode.parentNode;
                const selecionado = linha.dataset.fornecedor_id;
                selects[i].innerHTML = '';
                let option = document.createElement('option');
                option.setAttribute('value', '');
                selects[i].appendChild(option);
                for (var j = 0; j < orcamentos_label.length; j++) {
                    const pai_label = orcamentos_label[j].parentNode;
                    const arq = pai_label.querySelector('a[href]');
                    option = document.createElement('option');
                    option.setAttribute('value', arq.dataset.id);
                    option.innerText = orcamentos_label[j].innerHTML;
                    selects[i].appendChild(option);
                }
                selects[i].value = selecionado;
            }
            mostraBtnAprovacao();
        } else { //--> caso não exista orçamento inserido anteriormente
            for (var i = 0; i < selects.length; i++) {
                const selecionado = (selects[i].selectedIndex >= 0) ? selects[i].options[selects[i].selectedIndex].value : '';
                selects[i].innerHTML = '';
                let option = document.createElement('option');
                option.setAttribute('value', '');
                selects[i].appendChild(option);
                for (var j = 0; j < orcamentos_select.length; j++) {
                    if (orcamentos_select[j].options[orcamentos_select[j].selectedIndex].value != '') {
                        option = document.createElement('option');
                        option.setAttribute('value', orcamentos_select[j].options[orcamentos_select[j].selectedIndex].value);
                        option.innerText = orcamentos_select[j].options[orcamentos_select[j].selectedIndex].innerHTML;
                        selects[i].appendChild(option);
                    }
                }
                selects[i].value = selecionado;
            }
        }


    } catch (e) {
        alerta.erro(e, 10);
    }
}

function atualizarOrcamentos() {
    carregaOrcamentosItens();
}

function mostrarBtnAtualizarOrcamentos() {
    const orcamentos = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo select');
    for (var j = 0; j < orcamentos.length; j++) {
        if (orcamentos[j].options[orcamentos[j].selectedIndex].value != '') {
            document.getElementById('btn_atualiza_orcamentos').classList.remove('oculto');
            return;
        } else {
            document.getElementById('btn_atualiza_orcamentos').classList.add('oculto');
        }
    }
}

function salvaArquivo(indice) {
    try {
        var arquivo = document.getElementById('ctn_arquivos').querySelector('.a_arquivo:last-child');
        var pai = arquivo.parentNode;
        const data = new FormData();
        data.append('arquivo', document.getElementById('arquivo').files[indice]);
        ajax("salvaArquivo.php", data, function (resp) {
            document.body.style.cursor = '';
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }

                const arq = arquivo.querySelector('a[href]');
                const sel = arquivo.querySelector('select');
                arq.setAttribute('href', 'downloadArquivo.php?dir=' + r.dir);
                arq.dataset.path = r.dir;
                arq.innerHTML = r.nome;
                arquivo.classList.remove('oculto');
                sel.innerHTML = lista_fornecedores;
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

            container = document.getElementById('ctn_arquivos');
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
                    '  <div>' +
                    '    <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>' +
                    '    <a class="inserido"' +
                    '       href="downloadArquivo.php?dir="' +
                    '       data-path=""' +
                    '       target="_blank"' +
                    '       title="Visualizar Arquivo.">' +
                    nome +
                    '    </a>' +
                    '  </div>' +
                    '  <select id="fornecedor_arq_' + nome + '" onchange="mostrarBtnAtualizarOrcamentos()">' +
                    '  </select>' +
                    '</div>');
                salvaArquivo(i);
            }

            setTimeout(function () {
                mostrarBtnAtualizarOrcamentos();
            }, 500);

            alerta.sucesso('Arquivo(s) anexado(s) com sucesso.', 4);
        }
    } catch (e) {
        document.body.style.cursor = '';
        alerta.erro(e, 10);
    }
}

function remove_arquivo(a) {
    const node = a.parentNode.parentNode;
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
                'compra': document.getElementById('id').value,
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
            let arquivo = lista_arquivos[i].parentNode.parentNode;
            let container = arquivo.parentNode;
            container.removeChild(arquivo);
        }
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function salva(tipo) {
    try {
        formulario.valida(f);
        if (typeof tipo === 'undefined') {
            tipo = '';
        }

        document.getElementById('btn_salvar').classList.add('oculto');
        const itens = document.getElementById('ctn_itens').querySelectorAll('table tbody tr');
        let arrItens = [];
        for (var i = 0; i < itens.length; i++) {
            console.log(itens[i].dataset.id);
            const item = {
                'id': itens[i].dataset.id,
                'qtde': document.getElementById('qtde_' + itens[i].dataset.id).value,
                'vl_unit': document.getElementById('vl_unit_' + itens[i].dataset.id).value,
                'vl_total': document.getElementById('vl_total_' + itens[i].dataset.id).value,
                'orcamento': document.getElementById('orcamento_' + itens[i].dataset.id).value
            };
            arrItens.push(item);
        }
        let arquivos = [];
        const lista_arquivos = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo a.inserido');
        if (lista_arquivos.length > 0) {
            for (var i = 0; i < lista_arquivos.length; i++) {
                const pai = lista_arquivos[i].parentNode.parentNode;
                const orcamento = pai.querySelector('select');
                if (orcamento.value == '') {
                    throw 'Obrigatório informar um Fornecedor para cada orçamento anexado.';
                }
                const arquivo = {
                    'fornecedor_id': orcamento.value,
                    'orcamento_path': lista_arquivos[i].dataset.path,
                    'nome_arquivo': lista_arquivos[i].innerHTML
                };
                arquivos.push(arquivo);
            }
        }

        const data = new FormData();
        data.append('id', document.getElementById('id').value);
        data.append('tipo', tipo);
        data.append('itens', JSON.stringify(arrItens));
        data.append('arquivos', JSON.stringify(arquivos));

        ajax("salva.php", data, function (resp) {
            try {
                const r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                excluirArquivo();
                setTimeout(function () {
                    voltar();
                }, 5000);
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
        document.getElementById('btn_salvar').classList.remove('oculto');
    }

}

function carregaItens(dispositivo) {
    try {
        const params = query_string({
            'compra': document.getElementById('id').value,
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

function calculaValorTotal(campo) {
    try {
        const linha = campo.parentNode.parentNode;
        const qtde = linha.cells[1].querySelector('input');
        const total = linha.cells[3].querySelector('input');
        total.value = Numeros.real(qtde.value) * Numeros.real(campo.value);
        total.value = Numeros.moeda(total.value);
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function mostraBtnAprovacao() {
    try {
        const selects = document.getElementById('ctn_itens').querySelectorAll('table tbody select');
        document.getElementById('btn_envia_aprovacao').classList.remove('oculto');
        for (var i = 0; i < selects.length; i++) {
            if (selects[i].value == '') {
                document.getElementById('btn_salvar').classList.remove('oculto');
                document.getElementById('btn_envia_aprovacao').classList.add('oculto');
                return;
            } else {
                document.getElementById('btn_salvar').classList.add('oculto');
                return;
            }
        }
    } catch (e) {
        alerta.erro(e, 6);
    }
}

function voltar() {
    window.history.back();
}

let f = document.querySelector(".campos");
let obs = '';
let lista_fornecedores = '';

carregaFornecedores();

carregaItens(''); //--> demais dispositivos (tablet, desktop)

setTimeout(function () {
    carregaOrcamentosItens();
}, 500);