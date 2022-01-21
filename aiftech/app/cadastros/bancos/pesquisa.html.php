<table>
    <thead>
    <tr>
        <th class="centro">ID</th>
        <th class="">Nome</th>
        <th class="">Número</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Número" class=""><?= e($ret["numero"]) ?></td>
            <td class="acoes" title="Alterar dados">
                <div>
                    <?php if (Aut::temPermissao(Aut::$modulos['BANCOS'], \modelo\Permissao::REWRITE)): ?>
                        <a id="a_acao" class="alterar" href="banco.php?id=<?= $ret["id"] ?>"></a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>