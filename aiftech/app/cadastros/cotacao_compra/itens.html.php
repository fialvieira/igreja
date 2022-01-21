<?php foreach ($retorno as $item) : ?>
    <table>
        <thead>
        <tr>
            <th>Item</th>
            <th>Qtde</th>
            <th>Vl. Unit.</th>
            <th>Vl. Total</th>
            <th>Orçamento</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr data-id="<?= hs($item['produto_id']) ?>" data-fornecedor_id="<?= hs($item['fornecedores_id']) ?>">
            <td data-titulo="Item"><?= hs($item['produto_nome']) ?></td>
            <td data-titulo="Qtde" class="controle">
                <input id="qtde_<?= hs($item['produto_id']) ?>"
                       data-id="<?= hs($item['produto_id']) ?>"
                       type="text"
                       <?= $disabled ?>
                       class="real"
                       value="<?= hs(bd\Formatos::moeda($item['quantidade'])) ?>">
            </td>
            <td data-titulo="Vl. Unit." class="controle">
                <input id="vl_unit_<?= hs($item['produto_id']) ?>"
                       type="text"
                       class="real"
                       value="<?= hs(\bd\Formatos::moeda($item['valor_unitario'])) ?>"
                       onchange="calculaValorTotal(this)">
            </td>
            <td data-titulo="Vl. Total" class="controle">
                <input id="vl_total_<?= hs($item['produto_id']) ?>"
                       type="text"
                       value="<?= hs(\bd\Formatos::moeda($item['valor_total'])) ?>"
                       class="real"
                       disabled>
            </td>
            <td data-titulo="Orçamento">
                <select id="orcamento_<?= hs($item['produto_id']) ?>" onchange="mostraBtnAprovacao();">
                </select>
            </td>
            <td class="acoes">
                <div>
                    <a class="acao del" id="btn_<?= hs($item['produto_id']) ?>" onclick="excluiItem(this)"></a>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
<?php endforeach; ?>