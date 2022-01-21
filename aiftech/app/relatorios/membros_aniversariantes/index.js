function pesquisa() {
    try{
        formulario.valida(f);
        var strpar = query_string({
           'mes': document.getElementById('mes') .value
        });
        window.open('aniversariantes.php?' + strpar, '_blank');
    }catch (e){
        alerta.erro(e, 5);
    }

}

var f = document.querySelector('.qbe');