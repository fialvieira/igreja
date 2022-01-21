<table>
    <thead>
    <tr>
        <th class="coluna_dom">Dom</th>
        <th class="coluna_descricao">Descrição</th>
        <?php if (!$permitido): ?>
            <th>Ativo</th>
        <?php else: ?>
            <th></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Dom" class="coluna_dom"><?= e($ret["nome"]) ?></td>
            <td data-titulo="Descrição" class="coluna_descricao"><?= e($ret["observacoes"]) ?></td>
            <?php if (!$permitido): ?>
                <td data-titulo="Ativo"><?= e(($ret["ativo"] == "S") ? "Sim" : "Não") ?></td>
            <?php else: ?>
                <td class="acoes">
                    <div>
                        <a id="a_acao" class="alterar" title="Alterar dados" href="dom.php?id=<?= $ret["id"] ?>"></a>
                        <a class="<?= ($ret["ativo"] == "S") ? "ligado" : "desligado" ?>"
                           title="<?= ($ret["ativo"] == "S") ? "Desativar" : "Ativar" ?>"
                           data-id="<?= e($ret["id"]) ?>"
                           onclick="liga_desliga(this)"></a>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>