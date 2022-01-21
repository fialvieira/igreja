<?php
include "../../def.php";
try {
    Aut::loga($_POST['index_login'], $_POST['index_senha']);
    $ret = ['erro' => false];
} catch (\Exception $e) {
    $ret = ['erro' => true, 'mensagem' => $e->getMessage()];
}
echo json_encode($ret);