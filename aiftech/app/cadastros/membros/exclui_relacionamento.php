<?php

use modelo\Relacionamento;

include "../../../def.php";
try {
    Aut::filtraPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::REWRITE);

    $id = (isset($_GET['id']) && ($_GET['id'] !== '') && ($_GET['id'] !== 'undefined')) ? $_GET['id'] : null;;
    $retorno = new Relacionamento($id);

    $tipo_relacionamento_id = (isset($_GET['tipo_relacionamento_id']) && ($_GET['tipo_relacionamento_id'] !== '') && ($_GET['tipo_relacionamento_id'] !== 'undefined')) ? $_GET['tipo_relacionamento_id'] : null;
    $parente_id = (isset($_GET['parente_id']) && ($_GET['parente_id'] !== '') && ($_GET['parente_id'] !== 'undefined')) ? $_GET['parente_id'] : null;
    $parente_base_id = (isset($_GET['parente_base_id']) && ($_GET['parente_base_id'] !== '') && ($_GET['parente_base_id'] !== 'undefined')) ? $_GET['parente_base_id'] : null;

    /*if($tipo_relacionamento_id != 1 && $tipo_relacionamento_id != 2){
        $retorno->exclui();
    }else{*/
    switch ($tipo_relacionamento_id) {
        case 1:
            $relacionamento = 4;
            break;
        case 2:
            $relacionamento = 4;
            break;
        case 3:
            $relacionamento = 3;
            break;
        case 4:
            $relacionamento = 1;
            break;
    }
    $relacionamento_parente_id = Relacionamento::getIdPorParametros($parente_id, $parente_base_id, $relacionamento);
    $parente_ret = new Relacionamento($relacionamento_parente_id);
    $retorno->exclui();
    $parente_ret->exclui();
    /* }*/

    $ret = [
        "erro" => false,
        "mensagem" => 'Parentesco excluído com sucesso'
    ];

    echo json_encode($ret);
} catch (\Exception $e) {
    $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    echo json_encode($ret);
}