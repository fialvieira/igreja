<?php foreach ($retorno as $item) : ?>
    <div class="campo">
        <div class="controle">
            <?php if ($dispositivo != 'S'): ?>
                <div class="mensagem"></div>
            <?php endif; ?>
            <label><?= hs($item['produto_nome']) ?></label>
            <input id="qtde_<?= hs($item['produto_id']) ?>" 
                   data-id="<?= hs($item['produto_id']) ?>"
                   type="text"
                   <?= $disabled ?>
                   class="real"
                   value="<?= hs(bd\Formatos::moeda($item['quantidade'])) ?>">
            <!--onchange="calculaValorTotal()">-->
        <!--        <input id="vl_unit_<?= hs($item['produto_id']) ?>" 
        type="text"
        value="<?= hs($item['valor_unitario']) ?>"
        onchange="calculaValorTotal()">
        <input id="vl_total_<?= hs($item['produto_id']) ?>" type="text" value="<?= hs($item['valor_total']) ?>" disabled>-->
            <a class="acao del" id="btn_<?= hs($item['produto_id']) ?>" onclick="excluiItem(this)"></a>
            <?php if ($dispositivo == 'S'): ?>
                <div class="mensagem"></div>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
