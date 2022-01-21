<table>
    <thead>
    <tr>
        <th class="">Fornecedor</th>
        <th class="">Data</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Fornecedor" class=""><?= e($ret["fornecedor_nome"]) ?></td>
            <td data-titulo="Data" class=""><?= e(\bd\Formatos::dataApp($ret["data_orcamento"])) ?></td>
            <td class="acoes" title="Visualizar Orçamento">
                <div>
                    <a id="a_acao" class="download" href="downloadArquivo.php?dir=<?= $ret['orcamento_path'] ?>" target="_blank"></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>