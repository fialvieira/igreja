<option value=""></option>
<?php foreach ($meses as $k => $v): ?>
    <option value="<?= e($v['MES']) ?>"><?= e(mesPorExtenso($v['MES'])) ?></option>
<?php endforeach; ?>