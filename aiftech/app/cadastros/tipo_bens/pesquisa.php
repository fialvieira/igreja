<?php

use modelo\TipoBem;

include "../../../def.php";
try {

//  Aut::filtraAutorizacao(Aut::$modulos['TIPO_BENS']);
//  if (Aut::temPermissao(Aut::$modulos['TIPO_BENS'], \modelo\Permissao::REWRITE)) {
    $permitido = true;
//  } else {
//    $permitido = false;
//  }
  $retorno = TipoBem::seleciona();

  include "pesquisa.html.php";
} catch (\Exception $e) {
  \templates\Igreja::erro($e);
}
?>