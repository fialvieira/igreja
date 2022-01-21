<table>
    <thead>
        <tr>
            <th class="centro">Número</th>
            <th>Data</th>
            <th>Solicitante</th>
            <th>Justificativa</th>
            <!--<th>Situação</th>-->
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($retorno as $ret): ?>
            <tr>
                <td data-titulo="Número" class="centro"><?= e($ret["id"]) ?></td>
                <td data-titulo="Data"><?= e(($ret["data_solicitacao"] != '') ? \bd\Formatos::dataApp($ret["data_solicitacao"]) : '') ?></td>
                <td data-titulo="Solicitante"><?= e($ret["solicitante_nome"]) ?></td>
                <td data-titulo="Justificativa"><?= e($ret["justificativa"]) ?></td>
                <!--<td data-titulo="Situação"><?= e(\modelo\Compra::SITUACAO[$ret['situacao']]) ?></td>-->
                <td class="acoes">
                    <div>
                        <?php if ($permitido): ?>
                            <a id="a_acao" class="alterar" title="Inserir Cotações"
                               href="cotacao.php?id=<?= hs($ret["id"]) ?>"></a>
                           <?php endif; ?>
                        <a id="a_acao" class="detalhe" title="Mostrar orçamentos anexos."
                           onclick="mostra_arquivos(<?= hs($ret["id"]) ?>)"></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>