<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="centro">Quantidade</th>
      <th class="centro">Devolvido</th>
      <th class="">Membro</th>
      <th class="">Item</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Quantidade" class="centro"><?= e(\bd\Formatos::inteiro($ret["quantidade"])) ?></td>
      <td data-titulo="Devolvido" class="centro"><?= e(\bd\Formatos::inteiro($ret["devolvido"])) ?></td>
      <td data-titulo="Membro" class=""><?= e($ret["membro_descricao"]) ?></td>
      <td data-titulo="Item" class=""><?= e($ret["item_descricao"]) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="movimentacao_item.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="movimentacao_item.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>