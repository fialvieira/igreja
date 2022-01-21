<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="">Nome</th>
      <th class="">Email</th>
      <th class="">Telefone</th>
      <th class="centro">Congregacao</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
      <td data-titulo="Email" class=""><?= e(\bd\Formatos::email($ret["email"])) ?></td>
      <td data-titulo="Telefone" class=""><?= e(\bd\Formatos::telefoneApp($ret["telefone"])) ?></td>
      <td data-titulo="Congregacao" class="centro"><?= e(\bd\Formatos::inteiro($ret["congregacao_id"])) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="contato.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="contato.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>