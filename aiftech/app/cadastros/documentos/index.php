<?php

include "../../../def.php";

try {
  Aut::filtraAutorizacao(Aut::$modulos['DOCUMENTOS']);
  if (Aut::temPermissao(Aut::$modulos['DOCUMENTOS'], \modelo\Permissao::WRITE)) {
    $permitido = true;
  } else {
    $permitido = false;
  }
  $manual = RAIZ . "docs/manuais/Cadastro_Documentos.pdf";
  include "index.html.php";
} catch (\Exception $e) {
  \templates\Igreja::erro($e);
}