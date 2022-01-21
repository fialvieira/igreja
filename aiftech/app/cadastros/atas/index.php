<?php

include "../../../def.php";

try {
  Aut::filtraAutorizacao(Aut::$modulos['ATAS']);
  if (Aut::temPermissao(Aut::$modulos['ATAS'], \modelo\Permissao::WRITE)) {
    $permitido = true;
  } else {
    $permitido = false;
  }
  $manual = RAIZ . "docs/manuais/Cadastro_Atas.pdf";
  include "index.html.php";
} catch (\Exception $e) {
  \templates\Igreja::erro($e);
}