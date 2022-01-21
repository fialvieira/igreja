
<?php

include "../../../def.php";
require_once '../../../vendor/phpoffice/phpword/bootstrap.php';

try {
    Aut::filtraPermissao(Aut::$modulos['DOCUMENTOS'], \modelo\Permissao::WRITE);

    $id = (isset($_GET["id"]) && $_GET["id"] != "") ? $_GET["id"] : null;
    $retorno = new \modelo\Documento($id);

    $manual = RAIZ . "docs/manuais/Cadastro_Documentos.pdf";

    $listaMembros = [];
    if (!is_null($retorno->getMembros())) {
        $listaMembros = \modelo\Membro::getMembrosByListaId($retorno->getMembros());
    }
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

    $presidente = modelo\Membro::getMembroByCargo('P');
    foreach ($presidente as $p) {
        $eh_presidente = (array_search(Aut::$usuario->getCpf(), $p)) ? true : false;
    }

//    if (count($presidente) >= 1) {
//        $eh_presidente = (array_search(Aut::$usuario->getCpf(), $presidente[0])) ? true : false;
//    }
    $secretario = modelo\Membro::getMembroByCargo('S');
//    $membros = modelo\Membro::getMembrosQuorum('S');
    $membros = modelo\Membro::seleciona(null, 'S');
    $arrMembroCargos = [];
    foreach ($membros as $membro) {
        $arrMembroCargos[$membro['id']] [] = [
            'id' => $membro['id'],
            'nome' => $membro['nome']
        ];
    }
    $igrejas = \modelo\Empresa::listaIgrejas();
    $pastores = \modelo\Pastor::seleciona();
    $atas = modelo\Ata::seleciona();
    $arrArq = explode('/', $retorno->getPathArquivo());
    $nome_arq = $arrArq[count($arrArq) - 1];
//    $extensoes = [
//        'd' => 'Word',
//        'p' => 'PDF',
//        'h' => 'HTML',
//        'o' => 'ODT'
//    ];

    include "documento.html.php";
} catch (\Exception $e) {
    \templates\Igreja::erro($e);
}
?>