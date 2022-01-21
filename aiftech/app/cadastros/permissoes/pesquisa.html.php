<table>
    <thead>
        <tr>
            <th class="">Nome</th>
            <th class="">Login</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($retorno as $ret): ?>
            <tr>
                <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
                <td data-titulo="Login" class=""><?= e($ret["username"]) ?></td>
                <td class="acoes">
                    <div>
                        <a id="a_acao" title="Alterar dados" class="alterar" href="permissoes.php?user=<?= $ret["id"] ?>"></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>