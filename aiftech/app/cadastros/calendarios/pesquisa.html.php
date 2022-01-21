<table>
  <thead>
    <tr>
      <th class="centro">ID</th>
      <th class="">Datainicio</th>
      <th class="">Assunto</th>
      <th class="">Datafim</th>
      <th class="">Descricao</th>
      <th class="centro">Diatodo</th>
      <th class="">COR</th>
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Datainicio" class=""><?= e(\bd\Formatos::dataHoraApp($ret["datainicio"])) ?></td>
      <td data-titulo="Assunto" class=""><?= e($ret["assunto"]) ?></td>
      <td data-titulo="Datafim" class=""><?= e(\bd\Formatos::dataHoraApp($ret["datafim"])) ?></td>
      <td data-titulo="Descricao" class=""><?= e($ret["descricao"]) ?></td>
      <td data-titulo="Diatodo" class="centro"><?= e(\bd\Formatos::inteiro($ret["diatodo"])) ?></td>
      <td data-titulo="COR" class=""><?= e($ret["cor"]) ?></td>
      <td class="acoes" title="Alterar dados">
        <div>
          <a id="a_acao" class="alterar" href="calendario.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>
<!--      <td class="acoes" title="Excluir">
        <div>
          <a id="a_acao" class="excluir" href="calendario.php?id=<?= $ret["id"] ?>"></a>
        </div>
      </td>   -->   
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>