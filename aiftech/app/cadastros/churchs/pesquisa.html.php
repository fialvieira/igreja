<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="">Nome</th>
      <th class="">Cnpj</th>
      <th class="">Telefone</th>
      <th class="">Endereco</th>
      <th class="">Numero</th>
      <th class="">Complemento</th>
      <th class="">Bairro</th>
      <th class="">Cidade</th>
      <th class="">UF</th>
      <th class="">Email</th>
      <th class="">Matriz</th>
      <th class="centro">Tipo</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
      <td data-titulo="Cnpj" class=""><?= e(\bd\Formatos::cnpjApp($ret["cnpj"])) ?></td>
      <td data-titulo="Telefone" class=""><?= e(\bd\Formatos::telefoneApp($ret["telefone"])) ?></td>
      <td data-titulo="Endereco" class=""><?= e($ret["endereco"]) ?></td>
      <td data-titulo="Numero" class=""><?= e($ret["numero"]) ?></td>
      <td data-titulo="Complemento" class=""><?= e($ret["complemento"]) ?></td>
      <td data-titulo="Bairro" class=""><?= e($ret["bairro"]) ?></td>
      <td data-titulo="Cidade" class=""><?= e($ret["cidade"]) ?></td>
      <td data-titulo="UF" class=""><?= e($ret["uf"]) ?></td>
      <td data-titulo="Email" class=""><?= e(\bd\Formatos::email($ret["email"])) ?></td>
      <td data-titulo="Matriz" class=""><?= e($ret["matriz_id"]) ?></td>
      <td data-titulo="Tipo" class="centro"><?= e(\bd\Formatos::inteiro($ret["tipo"])) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="church.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="church.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>