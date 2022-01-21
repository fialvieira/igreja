function filtra(e) {
    var t = document.getElementById('j_produtos').querySelector("table tbody");
    full_text(e, t, document.getElementById('produto'), 1);
}

function adiciona_produto(linha) {
    try {
        var item = document.getElementById('ctn_itens').querySelector('#qtde_' + linha.cells[0].dataset.value);
        if (item) {
            throw 'Item já foi adicionado, verifique!';
        }

        var div_campo = document.createElement('div');
        var div_controle = document.createElement('div');
        var div_msg = document.createElement('div');
        var a = document.createElement('a');
        var input_qtde = document.createElement('input');
        var label = document.createElement('label');
//        var input_vl_unit = document.createElement('input');
//        var input_vl_tot = document.createElement('input');

        a.id = 'btn_' + linha.cells[0].dataset.value;
        a.classList.add('acao');
        a.classList.add('del');
        a.setAttribute('onclick', 'excluiItem(this)');
        input_qtde.id = 'qtde_' + linha.cells[0].dataset.value;
        input_qtde.dataset.id = linha.cells[0].dataset.value;
        input_qtde.value = '1';
        input_qtde.type = 'text';
        input_qtde.classList.add('real');
//        input_qtde.setAttribute('onchange','calculaValorTotal()');

//        input_vl_unit.id = 'vl_unit_' + linha.cells[0].dataset.value;
//        input_vl_unit.type = 'text';
//        input_vl_unit.value = '0,00';
//        input_vl_unit.onchange = 'calculaValorTotal()';
//
//        input_vl_tot.id = 'vl_total_' + linha.cells[0].dataset.value;
//        input_vl_tot.type = 'text';
//        input_vl_tot.value = '0,00';
//        input_vl_tot.disabled = true;
        label.innerHTML = linha.cells[0].innerHTML;
        div_msg.classList.add('mensagem');


        if (window.matchMedia("(min-width: 768px)").matches) {
            /* tablet pra cima */
            div_controle.appendChild(div_msg);
            div_controle.appendChild(label);
            div_controle.appendChild(input_qtde);
            div_controle.appendChild(a);
            //        div.appendChild(input_vl_unit);
            //        div.appendChild(input_vl_tot);
        } else {
            /* smartphone */
            div_controle.appendChild(label);
            div_controle.appendChild(input_qtde);
            div_controle.appendChild(a);
            //        div.appendChild(input_vl_unit);
            //        div.appendChild(input_vl_tot);
            div_controle.appendChild(div_msg);
        }

        div_controle.classList.add('controle');

        div_campo.appendChild(div_controle);
        div_campo.classList.add('campo');
        document.getElementById('ctn_itens').appendChild(div_campo);
        document.getElementById('qtde_' + linha.cells[0].dataset.value).focus();
        document.getElementById('produto').value = '';
        combo.fecha();
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function excluiItem(a) {
    var item = a.parentNode.parentNode;
    var ctn = item.parentNode;
    ctn.removeChild(item);

}

function salva() {
    try {
        var itens = document.getElementById('ctn_itens').querySelectorAll('.campo .controle input[type="text"]');
//        var itens = document.getElementById('ctn_itens').querySelectorAll('div');
        formulario.valida(f);

        if (itens.length < 1) {
            throw 'Obrigatório escolher pelo menos um item.';
        }

        var arrItens = [];
        for (var i = 0; i < itens.length; i++) {
            var item = {
                'id': itens[i].dataset.id,
                'qtde': itens[i].value
            };
            arrItens.push(item);
        }

//        var arquivos = [];
//        var lista_arquivos = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo a.inserido');
//        if (lista_arquivos.length > 0) {
//            for (var i = 0; i < lista_arquivos.length; i++) {
//                var arquivo = {
//                    'path': lista_arquivos[i].dataset.path,
//                    'nome': lista_arquivos[i].innerHTML,
//                    'ata_digit': ''
//                };
//                arquivos.push(arquivo);
//            }
//        }

//        var data = new FormData();
//        data.append('id', document.getElementById('id').value);
//        data.append('data', document.getElementById('data').value);
//        data.append('tipo', document.getElementById('tipo').value);
//        data.append('presidencia', document.getElementById('presidencia').value);
//        data.append('tx_corpo', document.getElementById('tx_corpo').value);
//        data.append('secretario', document.getElementById('secretario').value);
//        data.append('arquivos', JSON.stringify(arquivos));

        var params = query_string({
            'id': document.getElementById('id').value,
            'solicitante': document.getElementById('solicitante').value,
            'data_solicitacao': document.getElementById('data_solicitacao').value,
            'justificativa': document.getElementById('justificativa').value,
            'conta': document.getElementById('conta').value,
            'itens': JSON.stringify(arrItens)
        });
        ajax("salva.php", params, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
//                document.getElementById("id").value = r.ata;
//                document.getElementById("num").value = r.num;
//                excluirArquivo();
//                if (r.finalizado != 'S') {
//                } else {
//                    setTimeout(function () {
                document.getElementById('salvar').classList.remove('oculto');
                voltar();
//                    }, 1000);
//                }
            } catch (e) {
                alerta.erro(e, 10);
                document.getElementById('salvar').classList.remove('oculto');
            }
            document.getElementById('salvar').classList.add('oculto');
        }, 'post');
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
        document.getElementById('salvar').classList.remove('oculto');
    }
}

//function salvaArquivo(campo) {
//    try {
//        var arquivo = (campo == 'arquivo_ata') ? document.getElementById('ctn_ata').querySelector('.a_arquivo:last-child') :
//                document.getElementById('ctn_arquivos').querySelector('.a_arquivo:last-child');
//        var pai = arquivo.parentNode;
//
//        var data = new FormData();
//        data.append('arquivo', document.getElementById(campo).files[0]);
//
//        ajax("salvaArquivo.php", data, function (resp) {
//            try {
//                var r = JSON.parse(resp);
//                if (r.erro) {
//                    throw r.mensagem;
//                }
//                alerta.sucesso('Arquivo anexado com sucesso.', 4);
//                var arq = arquivo.querySelector('a[href]');
//                arq.setAttribute('href', 'downloadArquivo.php?dir=' + r.dir);
//                arq.dataset.path = r.dir;
//                arq.innerHTML = r.nome;
//                arquivo.classList.remove('oculto');
//            } catch (e) {
//                pai.removeChild(arquivo);
//                alerta.erro(e, 10);
//            }
//            document.body.style.cursor = '';
//            if (campo == 'arquivo_ata') {
//                var label = document.querySelector('label.file[for="' + campo + '"]');
//                label.classList.add('oculto');
//            }
//        });
//    } catch (e) {
//        pai.removeChild(arquivo);
//        document.body.style.cursor = '';
//        alerta.erro(e, 10);
//    }
//}

//function seleciona_arquivo(campo) {
//    var TAMANHO_MAXIMO = 2048;
//    try {
//        document.body.style.cursor = 'progress';
//        if (campo.files.length) {
//            var file = campo.files[0];
//            var tamanho = Math.round(file.size / 1024);
//            var extensao = file.type;
//
//            if (tamanho > TAMANHO_MAXIMO) {
//                throw 'Arquivo muito grande: ' + tamanho + ' KB. Máximo permitido: ' + TAMANHO_MAXIMO + ' KB.';
//            }
//            if (extensao != 'application/pdf') {
//                throw 'Permitido apenas arquivo do tipo PDF.';
//            }
//            var nome = file.name;
//            var container;
//            if (campo.id == 'arquivo_ata') {
//                container = document.getElementById('ctn_ata');
//            } else {
//                container = document.getElementById('ctn_arquivos');
//            }
//            container.insertAdjacentHTML('beforeend',
//                    '<div class="a_arquivo oculto">' +
//                    '  <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>' +
//                    '  <a class="inserido"' +
//                    '     href="downloadArquivo.php?dir="' +
//                    '     data-path=""' +
//                    '     target="_blank"' +
//                    '     title="Visualizar Arquivo.">' +
//                    nome +
//                    '  </a>' +
//                    '</div>');
//            salvaArquivo(campo.id);
//        }
//    } catch (e) {
//        document.body.style.cursor = '';
//        alerta.erro(e, 5);
//    }
//}

//function remove_arquivo(a) {
//    var node = a.parentNode;
//    var arquivo = node.querySelector('a[href]');
//    node.classList.add('excluido');
//    arquivo.classList.add('excluido');
//    arquivo.classList.remove('inserido');
//}

//function excluirArquivo() {
//    try {
//        var lista_arquivos = document.getElementById('ctn_arquivos').querySelectorAll('.a_arquivo a.excluido');
//
//        for (var i = 0; i < lista_arquivos.length; i++) {
//            var params = query_string({
//                'ata': document.getElementById('id').value,
//                'id': lista_arquivos[i].dataset.id,
//                'dir': lista_arquivos[i].dataset.path
//            });
//            ajax("excluiArquivo.php", params, function (resp) {
//                try {
//                    var r = JSON.parse(resp);
//
//                    if (r.erro) {
//                        throw r.mensagem;
//                    }
//                } catch (e) {
//                    alerta.erro(e, 10);
//                }
//            });
//        }
//    } catch (e) {
//        alerta.erro(e, 10);
//    }
//}

function carregaItens(dispositivo) {
    try {
        var params = query_string({
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

function voltar() {
    window.history.back();
}

var f = document.querySelector(".campos");

if (document.getElementById('produto')) {
    combo.registra(document.getElementById('produto'), document.getElementById('j_produtos'), filtra, adiciona_produto);
}

if (window.matchMedia("(min-width: 768px)").matches) {
    carregaItens(''); //--> demais dispositivos (tablet, desktop)
} else {
    carregaItens('S'); //--> (S)martphone
}
