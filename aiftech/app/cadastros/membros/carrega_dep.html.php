<option value=""></option>
<?php foreach ($retorno as $k => $v): ?>
    <option value="<?= e($v['id']) ?>"><?= e($v['nome']) ?></option>
<?php endforeach; ?>