<table>
    <thead>
        <tr>
            <th class="">Data Movim.</th>
            <th class="">Histórico</th>
            <th class="direita">Valor</th>
            <th class="direita">Saldo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($retorno): ?>
            <?php foreach ($retorno as $ret): ?>
                <?php
                $result = NULL;
                if ($ret['mov_financeira']) {
                    $result = modelo\MovimentacaoFinanceira::selecionaArquivos($ret['mov_financeira']);
                }
                $class_valor = '';
                $class_saldo = 'azul';
                if ($ret["tipo"] == 'D') :
                    $class_valor = 'vermelho';
                elseif ($ret["tipo"] == 'C') :
                    $class_valor = 'azul';
                endif;
                if ($ret["saldo"] < 0) :
                    $class_saldo = 'vermelho';
                endif;
                ?>
                <tr>
                    <td data-titulo="Data Movim." class=""><?= e(bd\Formatos::dataApp($ret["data"])) ?></td>
                    <td data-titulo="Histórico" class=""><?= e($ret["descricao"]) ?></td>
                    <td data-titulo="Valor" class="direita <?= $class_valor ?>">
                        <?= e(($ret["valor"] != '') ? \bd\Formatos::moeda($ret["valor"]) . ' ' . $ret["tipo"] : '') ?>
                    </td>
                    <td data-titulo="Saldo" class="direita negrito <?= $class_saldo ?>">
                        <?= e(bd\Formatos::moeda($ret["saldo"])) ?> <?= ($ret["saldo"] > 0) ? 'C' : 'D' ?>
                    </td>
                    <td class="acoes">
                        <?php if ($result) : ?>
                            <?php if (count($result) == 1) : ?>
                                <div>
                                    <a id="a_acao" class="download" title="Visualizar arquivo."  href="downloadArquivo.php?dir=<?= $result[0]['path'] ?>" target="_blank"></a>
                                </div>
                            <?php else: ?>
                                <div>
                                    <a id="a_acao" class="detalhe" title="Mostrar arquivos anexos." onclick="mostra_arquivos(<?= hs($ret["mov_financeira"]) ?>)"></a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?> 
    </tbody>
</table>