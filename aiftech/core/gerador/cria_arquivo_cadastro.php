<?php

$fields = "";
$params = "";
foreach ($campos as $campo) {
    if ($campo["CHAVE"] == "PRI") {
        $fields .= '$' . $campo["CAMPO"] . ' = (isset($_GET["'.$campo["CAMPO"].'"]) && $_GET["'.$campo["CAMPO"].'"] != "")? $_GET["'.$campo["CAMPO"].'"] : null;';
        $params .= '$' . $campo["CAMPO"] . ','; 
    }
}
$params = substr($params,0,-1);

$js = 
'function salva() {
  try {
    formulario.valida(f);
    ajax("salva.php", f, function (resp) {
      try {
        var r = JSON.parse(resp);
        if (r.erro) {
          throw r.mensagem;
        }
//        document.getElementById("cpf").value = r.cpf;
//        document.getElementById("cpf").style.disabled = true;
        alerta.sucesso("Salvo.", 3);
      } catch (e) {
        alerta.erro(e, 10);
      }
    });
    alerta.info("Salvando...");
  } catch (e) {
    alerta.erro(e, 10);
  }
}

function voltar() {
  window.history.back();
}

var f = document.querySelector(".campos");';

$css = 
'@media (min-width: 768px) {
  /*.campos input[type=text], 
  .campos input[type=password], 
  .campos select{
    width: 300px;
    margin-bottom: 0.25rem;
  }*/
  /*.campos textarea{
    width: 300px;
    height: 5rem;
  }*/
  /*.rotulo {
    vertical-align: top;
  }*/
}';

$php = '
<?php    

include "../../../def.php";

try {

    //$valor = (isset($_GET["valor"]) && $_GET["valor"] != "")? $_GET["valor"] : null;
    '.$fields.'
    $retorno = new \modelo\\' . $modelo . '('.$params.');
    ';
if ($relaciona_modelo) {
    foreach ($relaciona_modelo as $value) {
        $php .= '$'.$value['nome'].' = \modelo\\'.$value['modelo'].'::seleciona();
    ';
    }    
}
$php .= 
'$filtro = explode(",", '.$params.');    
    include "'.$nome_tabela.'.html.php";    
} catch (\Exception $e) {
    ' . $template . '::erro($e);
}
?>';

$html = 
'<?php $template = new ' . $template . '() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="'.$nome_tabela.'.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<!--<h1><a href="ndex.php">' . $titulo . '</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>-->
<h1><a onclick="voltar()">' . $titulo . '</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="' . e($tabela['tabela']) . '">
';
foreach ($campos as $campo):
    $input_type = "text";
    switch ($campo["TIPO"]) {
        case "email":
            $input_type = "email";
            break;
        case "telefone":
            $input_type = "tel";
            break;
    }

//    if ($campo["RELACIONA_TABELA"]) {
/*        $html .= '<?php $rel_tabela = gerador\Gerador::selecionaTabelaRelacionada("' . $campo["RELACIONA_TABELA"] . '"); ?>';*/
//    }
    //                    $combo = "";
    //                    if ($campo["COMBO"]) {
    //                        $combo = json_encode($combo);
    //                    }
    $get = str_replace(" ", "", ucwords(str_replace("_", " ", $campo['CAMPO'])));
    $formato_tipo = \gerador\Gerador::TipoFormato($campo["TIPO"], 'app');
    if ($formato_tipo != '') {
        $valor = $formato_tipo.'$retorno->get'.$get.'())';
    } else {
        $valor = '$retorno->get'.$get.'()';
    }
//    $valor = ($campo["RELACIONA_TABELA"] != "")? '$ret["'.$campo["CAMPO"] . '_descricao"]' : ($campo["COMBO"] != "")? '$ret["'.$campo["CAMPO"] . '_descricao"]' : $valor;

    if ($campo["AUTO_INCREMENTO"] == "S" || $campo["OCULTO"] == "S"):
        $html .= '                <input type="hidden" id="' . $campo["CAMPO"] . '" value="<?= e('.$valor.') ?>"> 
        ';
    else:
        if (strlen($campo["DESCRICAO"]) > "3") {
            $descricao = ucwords(str_replace("_", " ", $campo["DESCRICAO"]));
        } else {
            $descricao = strtoupper(str_replace("_", " ", $campo["DESCRICAO"]));
        }
        $descricao = str_replace(" Id", "", $descricao);
        $html .= '        <div class="campo">
                    <div class="rotulo">
        ';
        $html .= '                <label>' . $descricao . '</label>
        ';
        $html .= '            </div>
                    <div class="controle">
        ';
        if ($campo["RELACIONA_TABELA"] != "" || $campo["COMBO"] != ""): //$combo
            if ($campo["RELACIONA_TABELA"] != ""):
                $ret_relaciona = $relaciona_modelo[array_search($campo["RELACIONA_TABELA"], array_column($relaciona_modelo, 'nome'))];
                
                $filtro = ($campo["RELACIONA_FILTRO"]) ? 'data-filtro="' . hs($campo["RELACIONA_FILTRO"]) . '"' : "";
                $html .= '                <select id="' . $campo["CAMPO"] . '"
                                data-tabela="' . hs($campo["RELACIONA_TABELA"]) . '"
                                data-codigo="' . hs($campo["RELACIONA_VALOR"]) . '"
                                data-descricao="' . hs($campo["RELACIONA_DESCRICAO"]) . '"
                                ' . $filtro . '>   
                            <option value=""></option>     
                        <?php foreach ($'.$ret_relaciona['nome'].' as $tbl): ?>
                            <option value="<?= e($tbl["' . $ret_relaciona['id'] . '"]) ?>" 
                                    <?= ($tbl["' . $ret_relaciona['id'] . '"] == e('.$valor.'))? "selected" : "" ?>><?= ucwords($tbl["' . $campo["RELACIONA_DESCRICAO"] . '"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                ';
            else:
                $html .= '                <select id="' . $campo["CAMPO"] . '">
                            <option value=""></option> ';
                //                                            $combo = json_decode($combo);
                foreach ($campo["COMBO"] as $tbl):
                    $html .= '<option value="' . e($tbl["VALOR"]) . '"
                                      <?= ("' . $tbl["VALOR"] . '" == strtoupper(e('.$valor.')))? "selected" : "" ?>><?= ucwords("' . $tbl["DESCRICAO"] . '") ?></option>';
                endforeach;
                $html .= '              </select>';
            endif;
        else:
            $required = ($campo["OBRIGATORIO"] == "S") ? "required" : "";
            if ($campo["TIPO"] != "memo"):
                $class = ($campo["TIPO"] == "datahora") ? "data" : $campo["TIPO"];
                $casas = ($campo["TIPO"] == "real" || $campo["TIPO"] == "moeda") ? 'data-casas="' . $campo["CASA_DECIMAL"] . '"' : '';
                $maxlength = ($campo["TAMANHO_TEXTO"]) ? 'maxlength="' . $campo["TAMANHO_TEXTO"] . '"' : 'maxlength="' . ($campo["TAMANHO_NUM"] + $campo["CASA_DECIMAL"] + 1) . '"';
                $html .= '                <input type="' . $input_type . '" 
                               class="' . $class . '" 
                               id="' . $campo["CAMPO"] . '" 
                               ' . $casas . '
                               ' . $required . '
                               ' . $maxlength . '
                               value="<?= e('.$valor.') ?>">
                ';
            else:
                $maxlength = ($campo["TAMANHO_TEXTO"]) ? 'maxlength="' . $campo["TAMANHO_TEXTO"] . '"' : '';
                $html .= '                <textarea class="' . $campo["TIPO"] . '" 
                               id="' . $campo["CAMPO"] . '" 
                               ' . $required . '
                               ' . $maxlength . '><?= e('.$valor.') ?></textarea>
                ';
            endif;
        endif;
        $html .= '        <div class="mensagem"></div>
                    </div>
                </div>
        ';
    endif;
endforeach;
$html .= '    </div>
            <div class="botoes">
                <a class="botao" onclick="salva()">Salvar</a>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
</div>

    <?php $template->fimMain() ?>

    <?php $template->iniJs() ?>
    <script src="'.$nome_tabela.'.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>';

$salva = 
'<?php
    use modelo\\'.$modelo.';
    include "../../../def.php";
    try {
        $usuario = unserialize($_SESSION["usuario"]);
        $dh_atual = date("Y-m-d H:i:s");
        
        '.$fields.'
        $retorno = new '.$modelo.'('.$params.');
        ';

$data_atual = date('Y-m-d H:i');
foreach ($campos as $campo) {
    $pos_usuario = \gerador\Gerador::campoUsuario($campo['CAMPO']);
    $empresa = \gerador\Gerador::campoEmpresa($campo['CAMPO']);
    if ($campo["CHAVE"] != "PRI") {
        $valor = '(isset($_GET["'.$campo["CAMPO"].'"]) && $_GET["'.$campo["CAMPO"].'"] != "")? $_GET["'.$campo["CAMPO"].'"] : null';
        if ($pos_usuario && $campo['OCULTO'] == 'S') {// entra se for campo de usuario oculto, para salvar o usuario que fez a operacao (insert)
            $valor = '$usuario->getCodigo()';
        }
        if ($empresa != '' && $campo['OCULTO'] == 'S') {// entra se for campo de empresa oculto, para salvar a empresa que fez a operacao
            $valor = 'EMPRESA';
        }
        if ($campo['TIPO'] == 'datahora' && $campo['OCULTO'] == 'S') {// entra se for campo de data oculto, para salvar o data atual que foi feita a operacao
            $valor = '$dh_atual';
        }
        $pos1 = stripos($campo['CAMPO'], 'insert');
        $pos2 = stripos($campo['CAMPO'], 'created');
        if ($pos1 !== false || $pos2 !== false) {
            $valor = '($retorno->get'.str_replace(" ", "", ucwords(str_replace("_", " ", $campo["CAMPO"]))).'())? $retorno->get'.str_replace(" ", "", ucwords(str_replace("_", " ", $campo["CAMPO"]))).'() : $dh_atual';
        }
                
        $salva .= '$retorno->set' . str_replace(" ", "", ucwords(str_replace("_", " ", $campo["CAMPO"]))).'('.$valor.');
        ';
    }
}

$salva .=
       '$retorno->salva();
        $ret = ["erro" => false/*, "cpf" => $retorno->getCpf()*/];
    } catch (\Exception $e) {
        $ret = ["erro" => true, "mensagem" => $e->getMessage()];
    }
    echo json_encode($ret);
?>';

$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/';
if (!file_exists($dir)) {
    if (!mkdir($dir, 0777, true)) {
        throw new \Exception('Falha ao criar diretório do arquivo' . basename($dir) . '!!');
    }
}

//----------> js
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/'.$nome_tabela.'.js';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $js);
if ($fw != strlen($js)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}

//----------> css
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/'.$nome_tabela.'.css';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $css);
if ($fw != strlen($css)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}

//----------> php
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/'.$nome_tabela.'.php';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $php);
if ($fw != strlen($php)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}

//----------> html
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/'.$nome_tabela.'.html.php';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $html);
if ($fw != strlen($html)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}

//----------> salva
$dir = RAIZ . 'app/cadastros/' . $tabela['tabela'] . '/salva.php';
if (file_exists($dir)) {
    unlink($dir);
}
$fp = fopen($dir, "w");
$fw = fwrite($fp, $salva);
if ($fw != strlen($salva)) {
    throw new \Exception('Falha ao criar arquivo' . basename($dir) . '!!');
}
