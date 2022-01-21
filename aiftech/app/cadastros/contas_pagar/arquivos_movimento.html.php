<table>
    <thead>
    <tr>
        <th class="">Arquivo</th>
        <th class="">Data</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Arquivo" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Data" class=""><?= e(\bd\Formatos::dataApp($ret["dataupload"])) ?></td>
            <td class="acoes" title="Visualizar arquivo">
                <div>
                    <a id="a_acao" class="download" href="downloadArquivo.php?dir=<?= $ret['path'] ?>"
                       target="_blank"></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>