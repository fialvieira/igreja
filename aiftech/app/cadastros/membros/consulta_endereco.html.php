<?php foreach ($endereco as $k => $v): ?>
    <tr data-id="<?= hs($v["id"]) ?>" data-logradouro="<?= e($v["logradouro"]) ?>" data-bairro="<?= e($v["bairro"]) ?>"
        data-localidade="<?= e($v["localidade"]) ?>">
        <td data-value="<?= e($v["logradouro"]) ?>"><?= e($v["logradouro"]) ?></td>
    </tr>
<?php endforeach; ?>