<table>
    <thead>
    <tr>
        <th class="centro">Número</th>
        <th class="">Data</th>
        <th class="">Justificativa</th>
        <th class="">Situação</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Número" class="centro"><?= e($ret["id"]) ?></td>
            <td data-titulo="Data" class=""><?= e(\bd\Formatos::dataApp($ret["data_solicitacao"])) ?></td>
            <td data-titulo="Justificativa" class=""><?= e($ret["justificativa"]) ?></td>
            <td data-titulo="Situação" class=""><?= e($situacoes[$ret["situacao"]]) ?></td>
            <td class="acoes">
                <div>
                    <?php if ($permitido && $ret["situacao"] === 'S'): ?>
                        <a id="a_acao" class="alterar" title="Alterar dados"
                           href="solicitacao.php?id=<?= hs($ret["id"]) ?>"></a>
                    <?php endif; ?>
                    <?php if ($ret['situacao'] == 'A'): ?>
                        <a id="a_acao"
                           class="desligado"
                           title="Marcar serviço / produto entregue"
                           onclick="mudarStatus(this, <?= $ret['id'] ?>, 'E')"
                           ></a>
                    <?php endif; ?>
                    <a id="a_acao" class="detalhe" title="Mostrar orçamentos anexos."
                       onclick="mostra_arquivos(<?= hs($ret["id"]) ?>)"></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>