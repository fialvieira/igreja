<table>
    <thead>
        <tr>
            <th class="centro">Id</th>
            <th class="">Tipo</th>
            <th class="">Data</th>
            <th class="">Descrição</th>
            <th class="">Documento</th>
            <th class="">Contribuinte</th>
            <th class="">Conta</th>
            <th class="direita">Valor</th>
            <th class="">Centro de Custo</th>
            <th class="">Conta Bancária</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($retorno as $ret): ?>
            <tr>
                <td data-titulo="Id" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
                <td data-titulo="Tipo" class=""><?= e($tipo[$ret["tipo"]]) ?></td>
                <td data-titulo="Data" class=""><?= e(bd\Formatos::dataApp($ret["data"])) ?></td>
                <td data-titulo="Descrição" class=""><?= e($ret["descricao"]) ?></td>
                <td data-titulo="Documento" class=""><?= e($ret["documento"]) ?></td>
                <td data-titulo="Contribuinte" class=""><?= e($ret["contribuinte"]) ?></td>
                <td data-titulo="Conta" class=""><?= e($ret["categoria_financeira"]) ?></td>
                <td data-titulo="Valor" class="direita"><?= e(bd\Formatos::moeda($ret["valor"])) ?></td>
                <td data-titulo="Centro de Custo" class=""><?= e($ret["centro_custo"]) ?></td>
                <td data-titulo="Conta Bancária" class="cortar"><?= e($ret["conta_financeira"]) ?></td>
                <td class="acoes">
                    <div>
                        <?php if (Aut::temPermissao(Aut::$modulos['LANCAMENTOS_DIARIOS'], \modelo\Permissao::REWRITE)) : ?>
                            <!--<a id="a_acao" title="Alterar dados" class="alterar"
                               href="movimentacao_financeira.php?codigo=<?/*= $ret["id"] */?>"></a>-->
                        <?php endif; ?>
                        <?php if (Aut::temPermissao(Aut::$modulos['LANCAMENTOS_DIARIOS'], \modelo\Permissao::DEL)) : ?>
                            <a class="excluir"
                               title="Cancelar movimento"
                               onclick="cancelar(this)"></a>
                           <?php endif; ?>
                        <a id="a_acao" class="detalhe" title="Mostrar arquivos anexos." onclick="mostra_arquivos(<?= hs($ret["id"]) ?>)"></a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>