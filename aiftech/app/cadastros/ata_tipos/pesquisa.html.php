<table>
  <thead>
    <tr>
      <th class="centro">Id</th>
      <th class="">Descrição</th>
      <th class="">Registra Cartório?</th>
      <?php if (!$permitido): ?>
          <th>Ativo</th>
      <?php endif; ?>      
      <th></th>
    </tr>
  </thead>
  <tbody> 
<?php foreach ($retorno as $ret): ?>      
    <tr>
      <td data-titulo="Id" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
      <td data-titulo="Descricao" class=""><?= e($ret["descricao"]) ?></td>
      <td data-titulo="Registra Cartório?" class=""><?= e($arrCartorio[$ret["cartorio"]]) ?></td>
      <?php if (!$permitido): ?>
          <td data-titulo="Ativo"><?= e(($ret["ativo"] == "S") ? "Sim" : "Não") ?></td>
      <?php endif; ?>      
      <td class="acoes" title="Alterar dados">
        <div>
          <?php if ($permitido): ?>
              <a id="a_acao" title="Alterar dados" class="alterar" href="ata_tipo.php?id=<?= $ret["id"] ?>"></a>        
              <a class="<?= ($ret["ativo"] == "S") ? "ligado" : "desligado" ?>"
                 title="<?= ($ret["ativo"] == "S") ? "Desativar local" : "Ativar local" ?>"
                 onclick="liga_desliga(this)"></a>
          <?php endif; ?>          
        </div>
      </td>  
    </tr>
<?php endforeach; ?> 
  </tbody>
</table>

