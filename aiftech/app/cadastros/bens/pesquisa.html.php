<table>
  <thead>
    <tr>
      <th class="centro">Id</th>
      <th class="">Nome</th>
      <th class="">Identificação</th>
      <th class="">Nº Série</th>
      <th class="">Nº Ativo</th>
      <th class="">Marca</th>
      <th class="">Modelo</th>
      <th class="">Descrição</th>
      <th class="">Dt Compra</th>
      <th class="">Término Garantia</th>
      <th class="direita">Valor</th>
      <th class="">Departamento</th>
      <th class="">Local</th>
      <th class="">Tipo</th>
      <!--<th class="">Observação</th>-->
      <?php if (!$permitido): ?>
        <th>Ativo</th>
      <?php else: ?>
        <th></th>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody> 
    <?php foreach ($retorno as $ret): ?>      
      <tr>
        <td data-titulo="Id" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
        <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
        <td data-titulo="Identificação" class=""><?= e($ret["identificacao"]) ?></td>
        <td data-titulo="Nº Série" class=""><?= e($ret["num_serie"]) ?></td>
        <td data-titulo="Nº Ativo" class=""><?= e($ret["num_ativo"]) ?></td>
        <td data-titulo="Marca" class=""><?= e($ret["marca"]) ?></td>
        <td data-titulo="Modelo" class=""><?= e($ret["modelo"]) ?></td>
        <td data-titulo="Descrição" class=""><?= e($ret["descricao"]) ?></td>
        <td data-titulo="Dt Compra" class=""><?= e(\bd\Formatos::dataApp($ret["data_compra"])) ?></td>
        <td data-titulo="Término Garantia" class=""><?= e(\bd\Formatos::dataApp($ret["garantia"])) ?></td>
        <td data-titulo="Valor" class="direita"><?= e(\bd\Formatos::moeda($ret["valor_unitario"])) ?></td>
        <td data-titulo="Departamento" class=""><?= e($ret["departamento_descricao"]) ?></td>
        <td data-titulo="Local" class="centro"><?= e($ret["local_descricao"]) ?></td>
        <td data-titulo="Tipo" class=""><?= e($ret["tipobem_descricao"]) ?></td>
        <!--<td data-titulo="Observação" class=""><?= e($ret["observacao"]) ?></td>-->
        <?php if (!$permitido): ?>
          <td data-titulo="Ativo"><?= e(($ret["ativo"] == "S") ? "Sim" : "Não") ?></td>
        <?php else: ?>
          <td class="acoes">
            <div>
              <a id="a_acao" class="alterar" title="Alterar dados"
                 href="bem.php?id=<?= $ret["id"] ?>"></a>
                 <?php if ($permitido): ?>
                <a class="<?= ($ret["ativo"] == "S") ? "ligado" : "desligado" ?>"
                   title="<?= ($ret["ativo"] == "S") ? "Desativar bem" : "Ativar bem" ?>"
                   data-id="<?= e($ret["id"]) ?>"
                   onclick="liga_desliga(this)"></a>
                 <?php endif; ?>
            </div>
          </td>
        <?php endif; ?> 
      </tr>
    <?php endforeach; ?> 
  </tbody>
</table>