<table id="tbl_departamentos">
    <thead>
    <tr>
        <th class="">Nome</th>
        <th class="">Abreviação</th>
        <th>Tipo</th>
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
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Abreviação" class=""><?= e($ret["abreviacao"]) ?></td>
            <td data-titulo="Tipo"><?= e(($ret["tipo"] == 'D') ? 'Diretoria' : 'Ministério') ?></td>
            <?php if (!$permitido): ?>
                <td data-titulo="Ativo"><?= e(($ret["ativo"] == "S") ? "Sim" : "Não") ?></td>
            <?php else: ?>
                <td class="acoes">
                    <div>
                        <a id="a_acao" class="alterar" title="Alterar dados"
                           href="departamento.php?id=<?= $ret["id"] ?>"></a>
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