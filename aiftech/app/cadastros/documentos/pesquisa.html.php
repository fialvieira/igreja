<table>
    <thead>
    <tr>
        <th class="centro">Número</th>
        <th class="">Data</th>
        <th class="">Tipo</th>
        <th class="oculto"></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Número" class="centro"><?= e($ret["num"]) ?></td>
            <td data-titulo="Data" class=""><?= e(\bd\Formatos::dataApp($ret["data"])) ?></td>
            <td data-titulo="Tipo" class=""><?= e($ret["tipo_desc"]) ?></td>
            <td data-titulo="" class="oculto"><?= e($ret["documento_ft"]) ?></td>
            <td class="acoes">
                <div>
                    <?php if ($ret["finalizado"] != 'S'): ?>
                        <a id="a_acao" class="alterar" title="Alterar dados"
                           href="documento.php?id=<?= hs($ret["id"]) ?>"></a>
                        <!--<a id="a_acao" class="print" title="Gerar Documento" href="imprime.php?id=<?= hs($ret["id"]) ?>" target="_blank"></a>-->
                        <?php if (!is_null($tipo_individual[$ret["tipo_documento"]])) : ?>
                            <a id="a_acao" class="print" title="Gerar Documento"
                               onclick="imprime(<?= hs($ret["id"]) ?>, '<?= hs($tipo_individual[$ret["tipo_documento"]]) ?>', '<?= hs($ret["membros"]) ?>');"></a>
                        <?php endif; ?>
                        <?php if (Aut::temPermissao(Aut::$modulos['DOCUMENTOS'], modelo\Permissao::DEL)) : ?>
                            <a id="a_acao" class="del" title="Excluir Documento" data-id="<?= $ret["id"] ?>"
                               onclick="excluir(this)"></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <a id="a_acao" class="download" title="Visualizar Documento"
                           href="downloadArquivo.php?dir=<?= e($ret['path_arquivo']) ?>" target="_blank"></a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>