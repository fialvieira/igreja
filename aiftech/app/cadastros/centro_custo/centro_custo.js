function salva() {
    try {
        formulario.valida(f);
        var params = query_string({
            'codigo': document.getElementById('codigo').value,
            'descricao': document.getElementById('descricao').value,
            'principal': document.getElementById('principal').value,
            'muda_principal': (muda_principal === true)? 'S' : 'N'
        });
        ajax("salva.php", params, function (resp) {
            try {
                var r = JSON.parse(resp);
                if (r.erro) {
                    throw r.mensagem;
                }
                alerta.sucesso("Salvo.", 3);
                voltar();
            } catch (e) {
                alerta.erro(e, 10);
            }
        });
        alerta.info("Salvando...");
    } catch (e) {
        alerta.erro(e, 10);
    }
}

function mudaPrincipal() {
    if (document.getElementById('j_principal').dataset.principal != '') {
        modal.abre('j_principal', function (){
            muda_principal = false;
        });
    } else {
        muda_principal = true;
    }
    console.log(muda_principal);
}

function confirmaPrincipal() {
    modal.fecha();
    muda_principal = true;
    console.log(muda_principal);
}

function voltar() {
    window.history.back();
}

var f = document.querySelector(".campos");
var muda_principal = false;