<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="">Nome</th>
      <th class="">Email</th>
      <th class="centro">Idade</th>
      <th class="centro">DDD</th>
      <th class="">Telefone</th>
      <th class="centro">Tipo Telefone</th>
      <th class="">Cidade</th>
      <th class="">Estado</th>
      <th class="centro">Classificacao</th>
      <th class="">Infoad</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
      <td data-titulo="Email" class=""><?= e(\bd\Formatos::email($ret["email"])) ?></td>
      <td data-titulo="Idade" class="centro"><?= e(\bd\Formatos::inteiro($ret["idade"])) ?></td>
      <td data-titulo="DDD" class="centro"><?= e(\bd\Formatos::inteiro($ret["ddd"])) ?></td>
      <td data-titulo="Telefone" class=""><?= e(\bd\Formatos::telefoneApp($ret["telefone"])) ?></td>
      <td data-titulo="Tipo Telefone" class="centro"><?= e(\bd\Formatos::inteiro($ret["tipo_telefone"])) ?></td>
      <td data-titulo="Cidade" class=""><?= e($ret["cidade"]) ?></td>
      <td data-titulo="Estado" class=""><?= e($ret["estado"]) ?></td>
      <td data-titulo="Classificacao" class="centro"><?= e(\bd\Formatos::inteiro($ret["classificacao"])) ?></td>
      <td data-titulo="Infoad" class=""><?= e($ret["infoad"]) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="representante.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="representante.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>