<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="centro">Tipo</th>
      <th class="centro">Quantidade</th>
      <th class="centro">Saldo</th>
      <th class="">Motivo</th>
      <th class="">Bem</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Tipo" class="centro"><?= e(\bd\Formatos::inteiro($ret["tipo"])) ?></td>
      <td data-titulo="Quantidade" class="centro"><?= e(\bd\Formatos::inteiro($ret["quantidade"])) ?></td>
      <td data-titulo="Saldo" class="centro"><?= e(\bd\Formatos::inteiro($ret["saldo"])) ?></td>
      <td data-titulo="Motivo" class=""><?= e($ret["motivo"]) ?></td>
      <td data-titulo="Bem" class=""><?= e($ret["bem_descricao"]) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="movimentacao_bem.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="movimentacao_bem.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>