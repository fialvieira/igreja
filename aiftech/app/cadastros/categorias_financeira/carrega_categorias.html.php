<option value=""></option>
<?php foreach ($categorias_mae as $k => $v):
    $cat_mae_total = \modelo\CategoriasFinanceira::verificaCategoriaMae($v['id']);
    $classe = '';
    if ($cat_mae_total > 0) {
        $classe = 'negrito';
    }
    ?>
    <option value="<?= e($v["id"]) ?>" class="<?= $classe ?>"><?= e($v['num'] . ' - ' . $v['nome']) ?></option>
<?php endforeach; ?>