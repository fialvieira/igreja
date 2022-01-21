<table>
    <thead>
    <tr>
        <th class="centro">ID</th>
        <th class="">Nome</th>
        <th class="">Descrição</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Descrição" class=""><?= e($ret["descricao"]) ?></td>
            <?php if (!$permitido): ?>
                <td data-titulo="Ativo"><?= e(($ret["ativo"] == "S") ? "Sim" : "Não") ?></td>
            <?php else: ?>
                <td class="acoes">
                    <div>
                        <a id="a_acao" class="alterar" title="Alterar dados" href="tipo_produto.php?id=<?= $ret["id"] ?>"></a>
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