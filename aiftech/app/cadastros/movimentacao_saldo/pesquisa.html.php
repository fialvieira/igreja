<table>
    <thead>
    <tr>
        <th class="centro">Id</th>
        <th class="">Tipo</th>
        <th class="">Data</th>
        <th class="">Descrição</th>
        <th class="">Conta Origem</th>
        <th class="">Conta Destino</th>
        <th class="direita">Valor</th>
        <th class="direita">Saldo</th>
        <!--<th></th>-->
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Id" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
            <td data-titulo="Tipo" class=""><?= e($tipo[$ret["tipo"]]) ?></td>
            <td data-titulo="Data" class=""><?= e(bd\Formatos::dataApp($ret["data"])) ?></td>
            <td data-titulo="Descrição" class=""><?= e($ret["descricao"]) ?></td>
            <td data-titulo="Conta Origem" class=""><?= e($ret["CF_ORIGEM"] . ' - ' . $ret['BANCO_ORIGEM']) ?></td>
            <td data-titulo="Conta Destino" class=""><?= e($ret["CF_DESTINO"] . ' - ' . $ret['BANCO_DESTINO']) ?></td>
            <td data-titulo="Valor" class="direita"><?= e(\bd\Formatos::moeda($ret["valor"])) ?></td>
            <td data-titulo="Saldo" class="direita"><?= e(bd\Formatos::moeda($ret["saldo"])) ?></td>
            <!--<td class="acoes">
                <div>
                    <?php /*if (Aut::temPermissao(Aut::$modulos['MOVIMENTACAO_SALDOS'],
                        \modelo\Permissao::REWRITE)) : */?>
                        <a id="a_acao" title="Alterar dados" class="alterar"
                           href="movimentacao_saldo.php?codigo=<?/*= $ret["id"] */?>"></a>
                    <?php /*endif; */?>
                    <?php /*if (Aut::temPermissao(Aut::$modulos['MOVIMENTACAO_SALDOS'], \modelo\Permissao::DEL)) : */?>
                        <a class="excluir"
                           title="Cancelar movimento"
                           onclick="cancelar(this)"></a>
                    <?php /*endif; */?>
                </div>
            </td>-->
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>