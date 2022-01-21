<table>
    <thead>
    <tr>
        <th class="centro">Id</th>
        <th class="">Nome</th>
        <th class="centro">Sede</th>
        <?php if (!$edit): ?>
            <th>Ativo</th>
        <?php endif; ?>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Id" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Sede" class="centro"><?= e(($ret["sede"] === 'S') ? 'Sim' : 'Não') ?></td>
            <?php if (!$edit): ?>
                <td data-titulo="Ativo"><?= e(($ret["ativo"] == "S") ? "Sim" : "Não") ?></td>
            <?php endif; ?>
            <td class="acoes">
                <div>
                    <?php if ($edit): ?>
                        <a id="a_acao" title="Alterar dados" class="alterar"
                           href="local.php?codigo=<?= $ret["id"] ?>"></a>
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