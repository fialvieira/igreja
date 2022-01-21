<?php

include "../../../def.php";

try{
    $cargo = (isset($_GET["cargo"]) && $_GET["cargo"] != "") ? $_GET["cargo"] : null;
    $departamento = (isset($_GET["departamento"]) && $_GET["departamento"] != "") ? $_GET["departamento"] : null;
    if(is_null($cargo) || is_null($departamento)){
        throw new \Exception('Cargo e departamento devem ser selecionados');
    }
    $valida = \modelo\Membro::verificaCargosDepartamentos($cargo, $departamento, 'S');
    $ret = [
        'erro' => false,
        'ret' => $valida
    ];
    echo json_encode($ret);
}catch (\Exception $e){
    $ret = [
        'erro' => true,
        'msg' => $e->getMessage()
    ];
    echo json_encode($ret);
}