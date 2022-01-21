<option value=""></option>
<?php if ($todas): ?>
    <?php foreach ($contas as $k => $v): ?>
        <option value="<?= hs($v['id']) ?>">
            <?= e(($v['tipo_conta'] != 'V') ? $v['nome'] . ' (' . $v['agencia'] . ' - ' . $v['numero'] . ') - ' . $v['banco_descricao'] : $v['nome']) ?></option>
    <?php endforeach; ?>
    <?php else: ?>
    <?php foreach ($contas as $k => $v): ?>
        <option value="<?= hs($v['conta_id']) ?>">
            <?= e(($v['tipo_conta'] != 'V') ? $v['conta_nome'] . ' (' . $v['agencia'] . ' - ' . $v['numero'] . ') - ' . $v['banco_nome'] : $v['conta_nome']) ?></option>
    <?php endforeach; ?>
<?php endif; ?>
