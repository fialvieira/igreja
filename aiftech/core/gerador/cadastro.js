function salva() {
    try {
        formulario.valida(f);

        ajax('../../core/gerador/salva.php', f, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso('Salvo.');
                setTimeout(function () {
                    voltar();
                }, 500);
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info('Salvando...');
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function ao_mudar_cmb(el, tabela, codigo, descricao, id, filtro) {
    try {
        var params = query_string({
          'tabela': tabela,
          'codigo': codigo,
          'descricao': descricao,
          'filtro': filtro+" = '"+document.getElementById(id).value+"'"
        }); 
        ajax('../../core/gerador/cria_cmb.php', params, function (html) {
            try {
              document.getElementById(el).innerHTML = html;
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function voltar() {
    window.history.back();
}

var f = document.querySelector('.campos');
var id_onchange = f.querySelectorAll('select[data-filtro]');
for (var i = 0; i < id_onchange.length; i++) {
  var filtro = id_onchange[i].dataset.filtro.split('-');
  var id = filtro[0];
  if (filtro.length == 1) {
    var filtro = filtro[0];
  } else {
    var filtro = filtro[1];
  }
  document.getElementById(id).setAttribute('onchange',"ao_mudar_cmb('"+id_onchange[i].id+"','"+
                                                                       id_onchange[i].dataset.tabela+"','"+
                                                                       id_onchange[i].dataset.codigo+"','"+
                                                                       id_onchange[i].dataset.descricao+"','"+
                                                                       id+"','"+
                                                                       filtro+"')");
}
