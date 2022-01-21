<?php
$php = 
'<?php
    use modelo\\'.$modelo.';
    include "../../../def.php";
    try {
        //if (isset($_GET["texto"]) && $_GET["texto"] != "") {
        //    $texto = $_GET["texto"];
        //} else {
        //    $texto = null;
        //}
        //$retorno = '.$modelo.'::seleciona($texto);
          
        if (Aut::temPerfil(Aut::PERFIL_MASTER,Aut::PERFIL_ADMIN)) {
            $retorno = '.$modelo.'::seleciona("T");
            $permitido = true;
        } else {
            $retorno = '.$modelo.'::seleciona();
            $permitido = false;
        }

        include "pesquisa.html.php";
    } catch (\Exception $e) {
        '.$template.'::erro($e);
    }
?>';

$html = 
'<table>
  <thead>
    <tr>
      ';
      foreach ($campos as $campo){
        $tipo = '';
        if ($campo["RELACIONA_TABELA"] == ""){
          $tipo = ($campo["TIPO"] == "real" || $campo["TIPO"] == "moeda")? "direita" : (($campo["TIPO"] == "inteiro")? "centro" : "");
        }  
        if (strlen($campo["DESCRICAO"]) > "3"){
          $descricao = ucwords(str_replace("_", " ", $campo["DESCRICAO"]));
        }else{
          $descricao = strtoupper(str_replace("_", " ", $campo["DESCRICAO"]));
        }
        $descricao = str_replace(" Id", "", $descricao);

        if ($campo["OCULTO"] == "N"){
          $html .= '<th class="' . $tipo . '">' . $descricao . '</th>
      ';
        }
      }
$html .=       
'<th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      ';
        $filtro = "";
        foreach ($campos as $campo){ 
          $tipo = '';
          if ($campo["RELACIONA_TABELA"] == ""){
            $tipo = ($campo["TIPO"] == "real" || $campo["TIPO"] == "moeda")? "direita" : (($campo["TIPO"] == "inteiro")? "centro" : "");
          }  
          if (strlen($campo["DESCRICAO"]) > "3"){
            $descricao = ucwords(str_replace("_", " ", $campo["DESCRICAO"]));
          }else{
            $descricao = strtoupper(str_replace("_", " ", $campo["DESCRICAO"]));
          }
          $descricao = str_replace(" Id", "", $descricao);
          $desc = '';
          if ($campo["RELACIONA_TABELA"] != ""){
            $ret_relaciona = $relaciona_modelo[array_search($campo["RELACIONA_TABELA"], array_column($relaciona_modelo, 'nome'))];
            if ($ret_relaciona !== false) {
              $desc = str_replace(' ','_',strtolower($ret_relaciona['modelo'])).'_descricao';
            }
          }
          if ($campo["OCULTO"] == "N"){ 
            $formato_tipo = \gerador\Gerador::TipoFormato($campo["TIPO"], 'app');
            if ($formato_tipo != '') {
                $valor = $formato_tipo.'$ret["'.$campo["CAMPO"].'"])';
            } else {
                $valor = '$ret["'.$campo["CAMPO"].'"]';
            }
            if ($campo["CHAVE"] == "PRI") {
              $filtro .= '' . $campo["CAMPO"] . '=<?= $ret["'.$campo["CAMPO"] . '"] ?>&';
            }
            if ($desc != ''){
                $valor = '$ret["'.$desc.'"]';
            } else if ($campo["COMBO"] != ''){
                $valor = '$ret["'.$campo["CAMPO"] . '_descricao"]';
            }
            $html .= '<td data-titulo="' . $descricao . '" class="'.$tipo.'"><?= e('.$valor.') ?></td>
      ';
          } 
        } 
        $html .= '<td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="'.$nome_tabela.'.php?'.substr($filtro,0,-1).'"></a>
          <?php if ($permitido): ?>
            <a class="<?= ($ret["ativo"] == "S") ? "ligado" : "desligado" ?>" onclick="liga_desliga(this)"></a>
          <?php endif; ?>               
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="'.$nome_tabela.'.php?'.substr($filtro,0,-1).'"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>';

$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/';
if (!file_exists($dir)) {
    if (!mkdir($dir, 0777, true)) {
        throw new \Exception('Falha ao criar diretório do arquivo' . basename($dir) . '!!');
    }
} 

//--------> html
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/pesquisa.php';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $php);
if ($fw != strlen($php)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}
//--------> html
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/pesquisa.html.php';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $html);
if ($fw != strlen($html)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}

