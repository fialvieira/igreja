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
                        <?php if ($ret['situacao'] === 'A' || $ret['situacao'] === 'E'): ?>
                            <a class="<?= ($ret['situacao'] === 'E') ? 'detalhe' : 'alterar' ?>"
                               title="<?= ($ret['situacao'] === 'E') ? 'Detalhar Pagamento' : 'Cadastrar Pagamento' ?>"
                               href="movimentacao_financeira.php?codigo=<?= hs($ret["id"]) ?>"></a>
                            <a id="a_acao" class="detalhe" title="Mostrar orçamentos anexos."
                               onclick="mostra_arquivos(<?= hs($ret["id"]) ?>)"></a>
                        <?php endif; ?>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>