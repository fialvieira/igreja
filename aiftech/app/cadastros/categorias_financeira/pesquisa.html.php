<table id="tbl_resultado">
    <thead>
    <tr>
        <th class="centro">ID</th>
        <th>Conta</th>
        <th class="">Nome</th>
        <th class="">Descrição</th>
        <th class="">Tipo</th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($retorno as $ret):
        $cat_mae_total = \modelo\CategoriasFinanceira::verificaCategoriaMae($ret['id']);
        $mostra = true;
        $classe = '';
        if ($cat_mae_total > 0) {
            $mostra = false;
            $classe = 'negrito';
        }
        ?>
        <tr class="<?= $classe ?>" id="<?= e(\bd\Formatos::inteiro($ret["id"])) ?>"
            data-id="<?= e(\bd\Formatos::inteiro($ret["id"])) ?>"
            data-categoria_mae="<?= e($ret['categoria_mae']) ?>">
            <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
            <td data-titulo="Conta"><?= e($ret['num']) ?></td>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Descrição" class=""><?= e($ret["descricao"]) ?></td>
            <td data-titulo="Tipo" class=""><?= e(($ret['tipo'] == 'D') ? 'Despesa' : 'Receita') ?></td>
            <td class="acoes">
                <div>
                    <a id="a_acao" title="Alterar dados" class="alterar"
                       href="categorias_financeira.php?id=<?= $ret["id"] ?>"></a>
                </div>
            </td>
            <td class="acoes ativa_desativa">
                <div>
                    <?php if ($mostra): ?>
                        <a class="<?= ($ret["ativo"] == "S") ? "ligado" : "desligado" ?>"
                           title="<?= ($ret["ativo"] == "S") ? "Desativar" : "Ativar" ?>"
                           onclick="verificaMaeAiva(this)"></a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>