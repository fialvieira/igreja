<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="">Membro</th>
      <th class="">Tiporelacionamento</th>
      <th class="">Membro2</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Membro" class=""><?= e($ret["membro_descricao"]) ?></td>
      <td data-titulo="Tiporelacionamento" class=""><?= e($ret["tiporelacionamento_descricao"]) ?></td>
      <td data-titulo="Membro2" class=""><?= e($ret["membro_descricao"]) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="relacionamento.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="relacionamento.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>