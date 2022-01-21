<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="">Logradouro</th>
      <th class="">Numero</th>
      <th class="">Complemento</th>
      <th class="">Bairro</th>
      <th class="">CEP</th>
      <th class="">Cidade</th>
      <th class="">Estado</th>
      <th class="">Membro</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Logradouro" class=""><?= e($ret["logradouro"]) ?></td>
      <td data-titulo="Numero" class=""><?= e($ret["numero"]) ?></td>
      <td data-titulo="Complemento" class=""><?= e($ret["complemento"]) ?></td>
      <td data-titulo="Bairro" class=""><?= e($ret["bairro"]) ?></td>
      <td data-titulo="CEP" class=""><?= e(\bd\Formatos::cepApp($ret["cep"])) ?></td>
      <td data-titulo="Cidade" class=""><?= e($ret["cidade"]) ?></td>
      <td data-titulo="Estado" class=""><?= e($ret["estado_descricao"]) ?></td>
      <td data-titulo="Membro" class=""><?= e($ret["membro_descricao"]) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="endereco.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="endereco.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>