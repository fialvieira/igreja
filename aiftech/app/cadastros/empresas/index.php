<?php

include "../../../def.php";

try {
  Aut::filtraAutorizacao(Aut::$modulos['IGREJAS']);
  if (Aut::temPermissao(Aut::$modulos['IGREJAS'], \modelo\Permissao::WRITE)) {
    $permitido = true;
  } else {
    $permitido = false;
  }
  $manual = RAIZ . "docs/manuais/Cadastro_Igrejas.pdf";
  include "index.html.php";
} catch (\Exception $e) {
  \templates\Igreja::erro($e);
}
?>