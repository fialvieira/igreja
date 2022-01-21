<table>
    <thead>
        <tr>
            <th class="">Nº da Compra</th>
            <th class="">Fornecedor</th>
            <th class="">Data</th>
            <th class="">Valor</th>
            <th class="">Aprovado</th>
            <th></th>
        </tr>
    </thead>
    <tbody> 
        <?php foreach ($retorno as $ret): ?> 
            <tr>
                <td data-titulo="Nº da Compra" class=""><?= e($ret["compras_id"]) ?></td>
                <td data-titulo="Fornecedor" class=""><?= e($ret["fornecedor_nome"]) ?></td>
                <td data-titulo="Data" class=""><?= e(\bd\Formatos::dataApp($ret["data_orcamento"])) ?></td>
                <td data-titulo="Valor" class=""><?= e(\bd\Formatos::moeda($ret["valor"])) ?></td>
                <td data-titulo="Aprovado" class=""><?= e($tipo[$ret["aprovado"]]) ?></td>
                <td class="acoes" title="Visualizar Orçamento">
                    <div>
                        <a id="a_acao" class="download" href="downloadArquivo.php?dir=<?= $ret['orcamento_path'] ?>" target="_blank"></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?> 
    </tbody>
</table>