function salva() {
  try {
    formulario.valida(f);
    ajax("salva.php", f, function (resp) {
      try {
        var r = JSON.parse(resp);
        if (r.erro) {
          throw r.mensagem;
        }
        alerta.sucesso("Salvo.", 3);
      } catch (e) {
        alerta.erro(e, 10);
      }
    });
    alerta.info("Salvando...");
  } catch (e) {
    alerta.erro(e, 10);
  }
}

function voltar() {
  window.history.back();
}

var f = document.querySelector(".campos");