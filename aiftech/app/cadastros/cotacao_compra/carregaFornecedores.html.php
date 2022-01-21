    <option value=""></option>
<?php foreach ($retorno as $ret): ?> 
    <option value="<?= hs($ret["id"]) ?>"><?= e($ret["nome_fantasia"]) ?></option>
<?php endforeach; ?> 