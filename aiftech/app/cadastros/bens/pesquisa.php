<?php

use modelo\Bem;

include "../../../def.php";
try {
  Aut::filtraAutorizacao(Aut::$modulos['BENS']);
  if (Aut::temPermissao(Aut::$modulos['BENS'], \modelo\Permissao::REWRITE)) {
  $permitido = true;
  } else {
    $permitido = false;
  }
  $retorno = Bem::seleciona();

  include "pesquisa.html.php";
} catch (\Exception $e) {
  \templates\Igreja::erro($e);
}
?>