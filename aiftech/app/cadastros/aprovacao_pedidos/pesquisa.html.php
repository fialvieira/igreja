<table id="tbl_solicitantes">
    <thead>
    <tr>
        <th>Id</th>
        <th>Solicitante</th>
        <th>Data Solicitação</th>
        <th>Justificativa</th>
        <th>Situação</th>
        <?php if ($permitido): ?>
            <th></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Id"><?= e($ret["id"]) ?></td>
            <td data-titulo="Solicitante"><?= e($ret["solicitante_nome"]) ?></td>
            <td data-titulo="Data Solicitação"><?= e(($ret["data_solicitacao"] != '') ? \bd\Formatos::dataApp($ret["data_solicitacao"]) : '') ?></td>
            <td data-titulo="Justificativa"><?= e($ret["justificativa"]) ?></td>
            <td data-titulo="Situação"><?= e(\modelo\Compra::SITUACAO[$ret['situacao']]) ?></td>
            <?php if ($permitido): ?>
                <td class="acoes">
                    <div>
                        <?php if ($ret['situacao'] == 'S'): ?>
                            <a class="positivo"
                               title="Aprovar"
                               onclick="aprova(this, 'P', '<?= e($ret["id"]) ?>')"></a>
                            <a class="negativo"
                               title="Recusar"
                               onclick="aprova(this, 'R', '<?= e($ret["id"]) ?>')"></a>
                        <?php endif; ?>
                        <?php if ($ret['situacao'] !== 'F'): ?>
                            <a class="detalhe"
                               title="Detalhes Pedido"
                               onclick="detalhesPedido('<?= e($ret["id"]) ?>')"></a>
                        <?php else: ?>
                            <a class="alterar"
                               title="Aprovar/Reprovar Compra"
                               href="solicitacao.php?id=<?= hs($ret["id"]) ?>"></a>
                        <?php endif; ?>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>