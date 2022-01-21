<?php
include "../../../def.php";
try{

  $u = unserialize($_SESSION['usuario']);

  if(!Aut::temPerfil(Aut::PERFIL_MASTER)){
    Aut::eMembro($u->getChurch());
  }
  Aut::filtraPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::PRESIDENTE, Aut::ADMINISTRATIVO);

  $perfis = \modelo\Usuario::PERFIS;
  $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : null;
  $usuario = new \modelo\Usuario($codigo);
  include "usuario.html.php";
}catch(\Exception $e){
  \templates\Igreja::erro($e);
}
