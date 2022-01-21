<table>
    <thead>
    <tr>
        <th>Produto</th>
        <th>Quantidade</th>
        <th>Fornecedor</th>
        <th>Data</th>
        <th>Valor</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Produto" class=""><?= e($ret["produto_nome"]) ?></td>
            <td data-titulo="Quantidade"
                class=""><?= e(bd\Formatos::moeda($ret['quantidade']) . ' ' . \modelo\Produto::UNIDADES_MEDIDAS[$ret["unidade_medida"]]) ?></td>
            <td data-titulo="Fornecedor" class=""><?= e($ret["fornecedor_nome"]) ?></td>
            <td data-titulo="Data" class=""><?= e(\bd\Formatos::dataApp($ret["data_orcamento"])) ?></td>
            <td data-titulo="Valor" class=""><?= e(\bd\Formatos::moeda($ret["valor"])) ?></td>
            <td class="acoes" title="Visualizar Orçamento">
                <div>
                    <a id="a_acao" class="download"
                       href="downloadArquivo.php?dir=<?= $ret['orcamento_path'] ?>"
                       target="_blank"></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>