<?php

include "../../../def.php";

try {
    $dir = $_GET['dir'];

    if (!file_exists($dir)) {
        echo 'Arquivo não encontrado, verifique!';
        die();
    }

    header('Content-Description: File Transfer');
    header('Content-Disposition: inline; filename="' . basename($dir) . '"');
    header('Content-Type: application/pdf');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($dir));
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');

    readfile($dir);
} catch (Exception $ex) {
    echo json_encode(['ERRO' => true, 'MSG' => 'Erro ao Efetuar o Download do arquivo.']);
}