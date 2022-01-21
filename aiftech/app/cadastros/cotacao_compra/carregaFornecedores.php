<?php

use modelo\Fornecedor;

include "../../../def.php";
try {
    
    $retorno = Fornecedor::seleciona('S');

    if ($retorno) {
        include "carregaFornecedores.html.php";
    }
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>