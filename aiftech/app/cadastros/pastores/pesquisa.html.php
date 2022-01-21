<table>
    <thead>
    <tr>
        <th class="centro">ID</th>
        <th class="">Nome</th>
        <th class="">Tratamento</th>
        <th class="">Função na Igreja</th>
        <?php if ($permitido): ?>
            <th></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Tratamento" class=""><?= e($ret["tratamento"]) ?></td>
            <td data-titulo="Função na Igreja" class=""><?= e(modelo\Pastor::FUNCAO[$ret["categoria"]]) ?></td>
            <?php if ($permitido): ?>
                <td class="acoes">
                    <div>
                        <a id="a_acao" class="alterar" title="Alterar dados" href="pastor.php?id=<?= $ret["id"] ?>"></a>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>