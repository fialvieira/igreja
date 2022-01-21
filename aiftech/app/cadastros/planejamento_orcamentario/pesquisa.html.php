<table>
    <thead>
        <tr>
            <th class="centro">Id</th>
            <th class="">Mês</th>
            <th class="">Conta</th>
            <th class="direita">Valor Previsto</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($retorno as $ret): ?>
            <tr>
                <td data-titulo="Id" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
                <td data-titulo="Mês" class=""><?= e(mesPorExtenso($ret["mes"])) ?></td>
                <td data-titulo="Conta" class=""><?= e($ret["categoria_descricao"]) ?></td>
                <td data-titulo="Valor Previsto" class="direita"><?= e(bd\Formatos::moeda($ret["valor_previsto"])) ?></td>
                <td class="acoes">
                    <div>
                        <?php if (Aut::temPermissao(Aut::$modulos['PLANEJAMENTO_ORCAMENTARIO'], \modelo\Permissao::REWRITE)) : ?>
                            <?php if ($ret['ano'] > $year || ($ret['ano'] == $year && $ret['mes'] > $month)) : ?>
                                <a id="a_acao" title="Alterar dados" class="alterar"
                                   href="planejamento_orcamentario.php?codigo=<?= $ret["id"] ?>"></a>
                               <?php endif; ?>
                           <?php endif; ?>
                           <?php // if (Aut::temPermissao(Aut::$modulos['PLANEJAMENTO_ORCAMENTARIO'], \modelo\Permissao::DEL)) : ?>
                        <!--                        <a class="excluir"
                                                   title="Cancelar movimento"
                                                   onclick="cancelar(this)"></a>-->
                        <?php // endif; ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>