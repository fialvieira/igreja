<?php

include "../../../def.php";

try {
  Aut::filtraAutorizacao(Aut::$modulos['TIPOS_DOCUMENTO']);
  if (Aut::temPermissao(Aut::$modulos['TIPOS_DOCUMENTO'], \modelo\Permissao::WRITE)) {
    $permitido = true;
  } else {
    $permitido = false;
  }
  $manual = RAIZ . "docs/manuais/Cadastro_Tipos_Documento.pdf";
  include "index.html.php";
} catch (\Exception $e) {
  \templates\Igreja::erro($e);
}
?>