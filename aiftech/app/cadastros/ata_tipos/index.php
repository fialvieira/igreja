<?php

include "../../../def.php";

try {
  Aut::filtraAutorizacao(Aut::$modulos['TIPOS_ATA']);
  if (Aut::temPermissao(Aut::$modulos['TIPOS_ATA'], \modelo\Permissao::WRITE)) {
    $permitido = true;
  } else {
    $permitido = false;
  }
  $manual = RAIZ . "docs/manuais/Cadastro_Tipos_Ata.pdf";
  include "index.html.php";
} catch (\Exception $e) {
  \templates\Igreja::erro($e);
}
?>