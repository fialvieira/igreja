<?php

use gerador\TabelasAuto;

include "../../def.php";

$tabela = $_GET['tabela'];
$codigo = $_GET['codigo'];
$descricao = $_GET['descricao'];
$filtro = (isset($_GET['filtro'])) ? $_GET['filtro'] : null;

$dados = TabelasAuto::selecionaTabelaRelacionada($tabela, $filtro);
?>
<option value=""></option>
<?php foreach ($dados as $dado): ?>
  <option value="<?= hs($dado[$codigo]) ?>"><?= e($dado[$descricao]) ?></option>
<?php endforeach; ?>

