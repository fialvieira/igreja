<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="">Nome</th>
      <th class="">Descricao</th>
      <th class="">Tipo</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
      <td data-titulo="Descricao" class=""><?= e($ret["descricao"]) ?></td>
      <td data-titulo="Tipo" class=""><?= e($ret["tipo_descricao"]) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="grupos_financeiro.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="grupos_financeiro.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>