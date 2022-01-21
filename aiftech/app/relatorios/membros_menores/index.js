function pesquisa() {
    try{
        formulario.valida(f);
        var strpar = query_string({
           'ativo': document.getElementById('ativo') .value,
            'quorum': document.getElementById('quorum').value
        });
        window.open('membros_menores.php?' + strpar, '_blank');
    }catch (e){
        alerta.erro(e, 5);
    }
}

var f = document.querySelector('.qbe');