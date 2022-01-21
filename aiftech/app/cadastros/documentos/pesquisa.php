<?php

use modelo\Documento;

include "../../../def.php";
require_once '../../../vendor/phpoffice/phpword/bootstrap.php';

try {

    $retorno = Documento::seleciona();
    $tipos = \modelo\DocumentoTipo::seleciona('S', 'S');
    $tipo_individual = [];
    foreach ($tipos as $tipo) {
        if (file_exists($tipo['path_modelo'])) {
            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($tipo['path_modelo']);
            $listaVariaveis = $templateProcessor->getVariables();
            $value = 'N';
            if (array_search('listaNomesMembros', $listaVariaveis) === false) {
                $value = 'S';
            }
            $tipo_individual[$tipo['id']] = $value;
        } else {
            $tipo_individual[$tipo['id']] = null;
        }
    }

    include "pesquisa.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>