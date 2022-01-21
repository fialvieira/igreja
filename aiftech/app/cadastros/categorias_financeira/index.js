function pesquisa() {
    try {
        var grid = document.querySelector(".container-grid .grid");

        function retorno(html) {
            grid.innerHTML = html;
            var tr = grid.querySelectorAll("table tbody tr");
            if (tr.length == 0) {
                grid.innerHTML = "";
                alerta.erro("Nenhum registro encontrado", 3);
            }
            document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
            if (document.getElementById("txt_pesquisa").value) {
                var hash = historico.hash();
                hash.texto = document.getElementById("txt_pesquisa").value;
                historico.push(hash);
            }
        }

        var parametros = query_string({
            "texto": document.getElementById("txt_pesquisa").value
        });
        ajax("pesquisa.php", parametros, retorno);
        grid.innerHTML = templates.CARREGANDO;
        document.getElementById("total_registros").innerHTML = "";
    } catch (e) {
        alerta.erro(e, 8);
    }
}

historico.load(function (hash) {
    if (hash.texto) {
        document.getElementById("txt_pesquisa").value = hash.texto;
        delete hash.texto;
        historico.push(hash);
        pesquisa();
    } else {
        document.getElementById("txt_pesquisa").innerHTML = "";
    }
});

function filtra(e) {
    var hash = historico.hash();
    var t = document.querySelector(".container-grid .grid table tbody");
    full_text(e, t, document.getElementById("txt_pesquisa"));
    if (!document.getElementById("txt_pesquisa").value) {
        delete hash.texto;
    } else if (eval(document.getElementById("txt_pesquisa").value.length % 3) == 0) {
        hash.texto = document.getElementById("txt_pesquisa").value;
    }
    historico.push(hash);
    var tr = t.querySelectorAll("tr:not(.oculto)");
    document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
}

function verificaSeCategoriaMaeTemFilhos(linha) {
    try {
        var cat_mae = linha.dataset.categoria_mae;
        if (cat_mae != '') {
            var strpar = query_string({
                'cat_mae_id': cat_mae
            });
            ajax('verifica_cat_mae.php', strpar, function (json) {
                try {
                    var r = JSON.parse(json);
                    if (r.erro) {
                        throw r.mensagem;
                    } else {
                        if (r.existe) {
                            var linha_mae = document.getElementById(cat_mae);
                            var td = linha_mae.querySelector('.ativa_desativa');
                            td.innerHTML = '<div></div>';
                        } else {
                            var linha_mae = document.getElementById(cat_mae);
                            var td = linha_mae.querySelector('.ativa_desativa');
                            console.log(td);
                            td.innerHTML = '<div>' +
                                '<a class="ligado" title="Desativar" onclick="liga_desliga(this)"></a>' +
                                '</div>';
                        }
                    }
                } catch (e) {
                    alerta.erro(e, 5);
                }
            });
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function verificaMaeAiva(a) {
    try {
        var linha = a.parentNode.parentNode.parentNode;
        var cat_mae_id = linha.dataset.categoria_mae;
        if (cat_mae_id != '') {
            var strpar = query_string({
                'cat_mae_id': cat_mae_id
            });
            ajax('verifica_mae_ativa.php', strpar, function (json) {
                try {
                    var r = JSON.parse(json);
                    if (r.erro) {
                        throw r.mensagem;
                    } else {
                        if (r.ativa) {
                            liga_desliga(a);
                        } else {
                            throw 'Categoria mãe está inativa';
                        }
                    }
                } catch (e) {
                    alerta.erro(e, 5);
                }
            })
        } else {
            liga_desliga(a);
        }
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function liga_desliga(a) {
    try {
        var linha = a.parentNode.parentNode.parentNode;
        var id = linha.dataset.id;
        var ativo = (a.classList.contains("ligado")) ? "N" : "S";
        var param = query_string({
            "id": id,
            "ativo": ativo
        });
        ajax('altera_status.php', param, function (json) {
            try {
                var r = JSON.parse(json);
                if (r.erro) {
                    throw r.mensagem;
                } else {
                    var old = (ativo == 'N') ? 'ligado' : 'desligado';
                    var novo = (old == 'ligado') ? 'desligado' : 'ligado';
                    mudaClasse(a, old, novo);
                    mudaAtributo(a, 'title', (novo == 'ligado') ? 'Desativar' : 'Ativar');
                    alerta.sucesso(r.mensagem, 5);
                    verificaSeCategoriaMaeTemFilhos(linha);
                }
            } catch (e) {
                alerta.erro(e, 5);
            }
        });
    } catch (e) {
        alerta.erro(e, 5);
    }
}

function mudaClasse(objeto, classe_old, classe_new) {
    if (objeto.classList.contains(classe_old)) {
        objeto.classList.remove(classe_old);
        objeto.classList.add(classe_new);
    }
}

function mudaAtributo(objeto, atributo, texto) {
    objeto.setAttribute(atributo, texto);
}

pesquisa();