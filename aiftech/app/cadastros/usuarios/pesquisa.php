<?php
include "../../../def.php";
try{
  $u = unserialize($_SESSION['usuario']);

  if(!Aut::temPerfil(Aut::PERFIL_MASTER)){
    Aut::eMembro($u->getChurch());
  }
  Aut::filtraPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::PRESIDENTE, Aut::ADMINISTRATIVO);
  
  $status = $_GET['status'];
  $pesquisa = $_GET['usuario'];
  $igreja_id = EMPRESA;
  $perfis = \modelo\Usuario::PERFIS;
  $usuarios = \modelo\Usuario::seleciona($igreja_id, $pesquisa, $status);
  include "pesquisa.html.php";
}catch(\Exception $e){
  \templates\Igreja::erro($e);
}