function pesquisa() {
  try {
    var grid = document.querySelector(".container-grid .grid");

    var parametros = query_string({});
    ajax("pesquisa.php", parametros, function (html) {
      try {
        grid.innerHTML = html;
        var tr = grid.querySelectorAll("table tbody tr");
        if (tr.length == 0) {
          grid.innerHTML = "";
        }
        document.getElementById("total_registros").innerHTML = tr.length + " registros encontrados";
        if (document.getElementById("txt_pesquisa").value) {
          var hash = historico.hash();
          hash.texto = document.getElementById("txt_pesquisa").value;
          historico.push(hash);
          filtra(evento);
        }
      } catch (e) {
        alerta.erro(e, 8);
      }

    });
    grid.innerHTML = templates.CARREGANDO;
    document.getElementById("total_registros").innerHTML = "";
  } catch (e) {
    alerta.erro(e, 8);
  }
}

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

function liga_desliga(a) {
  try {
    if (a.classList.contains("ligado")) {
      a.classList.remove("ligado");
      a.classList.add("desligado");
    } else {
      a.classList.remove("desligado");
      a.classList.add("ligado");
    }
    var linha = a.parentNode.parentNode.parentNode;
    var ativo = (a.classList.contains("ligado")) ? "S" : "N";
    var param = query_string({
      "id": a.getAttribute('data-id'),
      "ativo": ativo
    });
    ajax("salva.php", param, function (resp) {
      try {
        var r = JSON.parse(resp);
        if (r.erro) {
          throw r.mensagem;
        }
      } catch (e) {
        alerta.erro(e, 10);
      }
    });
  } catch (e) {
    alerta.erro(e, 10);
  }
}

var evento = new Event("keyup");
evento.keyCode = 13;

historico.load(function (hash) {
  if (hash.texto) {
    document.getElementById("txt_pesquisa").value = hash.texto;
    pesquisa();
    setTimeout(function () {
      filtra(evento);
    }, 100);
  } else {
    document.getElementById("txt_pesquisa").innerHTML = "";
  }
});

pesquisa();