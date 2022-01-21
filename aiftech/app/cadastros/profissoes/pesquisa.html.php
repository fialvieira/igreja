<table>
    <thead>
    <tr>
        <th class="centro">ID</th>
        <th class="">Nome</th>
        <th class="">Descricao</th>
        <?php if (Aut::temPermissao(Aut::$modulos['PROFISSOES'], \modelo\Permissao::REWRITE)): ?>
            <th></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Descricao" class=""><?= e($ret["descricao"]) ?></td>
            <?php if (Aut::temPermissao(Aut::$modulos['PROFISSOES'], \modelo\Permissao::REWRITE)): ?>
                <td class="acoes" title="Alterar dados">
                    <div>
                        <a id="a_acao" class="alterar" href="profissao.php?id=<?= $ret["id"] ?>"></a>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>