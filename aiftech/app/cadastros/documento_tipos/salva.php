<?php
    use modelo\DocumentoTipo;
    include "../../../def.php";
    try {
        Aut::filtraPermissao(Aut::$modulos['TIPOS_DOCUMENTO'], \modelo\Permissao::WRITE);
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        $id = (isset($_GET["id"]) && $_GET["id"] != "")? $_GET["id"] : null;
        $retorno = new DocumentoTipo($id);
        if (isset($_GET["descricao"]) && $_GET["descricao"]){
          $retorno->setDescricao($_GET["descricao"]);
        }      
        if (isset($_GET["path_modelo"]) && $_GET["path_modelo"]){
          if (!file_exists($_GET["path_modelo"])) {
              throw new \Exception('Falha ao salvar o arquivo, verifique.');
          }  
          $retorno->setPathModelo($_GET["path_modelo"]);
        } else {
          $retorno->setPathModelo(NULL);  
        }     
        if (isset($_GET["ativo"]) && $_GET["ativo"]){
          $retorno->setAtivo($_GET["ativo"]);
        }              
        $retorno->setEmpresaId(EMPRESA);
        $retorno->setUserId($usuario->getCodigo());
        $retorno->setCreated(($retorno->getCreated())? $retorno->getCreated() : $dh_atual);
        $retorno->setModified($dh_atual);
        $retorno->salva();
        $ret = ["erro" => false];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>