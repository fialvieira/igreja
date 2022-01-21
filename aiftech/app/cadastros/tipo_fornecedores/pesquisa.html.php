<table>
    <thead>
    <tr>
        <!--<th class="centro">Id</th>-->
        <th class="">Descrição</th>
        <?php if (!$permitido): ?>
            <th>Ativo</th>
        <?php else: ?>
            <th></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <!--<td data-titulo="Id" class="centro"><?/*= e(\bd\Formatos::inteiro($ret["id"])) */?></td>-->
            <td data-titulo="Descricao" class=""><?= e($ret["descricao"]) ?></td>
            <?php if (!$permitido): ?>
                <td data-titulo="Ativo"><?= e(($ret["ativo"] == "S") ? "Sim" : "Não") ?></td>
            <?php else: ?>
                <td class="acoes">
                    <div>
                        <a id="a_acao" class="alterar" title="Alterar dados"
                           href="tipo_fornecedor.php?id=<?= $ret["id"] ?>"></a>
                        <?php if ($permitido): ?>
                            <a class="<?= ($ret["ativo"] == "S") ? "ligado" : "desligado" ?>"
                               title="<?= ($ret["ativo"] == "S") ? "Desativar tipo fornecedor" : "Ativar tipo fornecedor" ?>"
                               data-id="<?= e($ret["id"]) ?>"
                               onclick="liga_desliga(this)"></a>
                        <?php endif; ?>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>