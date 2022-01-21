<table id="tbl_detalhes">
    <thead>
    <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Tipo Produto</th>
        <th>Tipo</th>
        <th>Quantidade</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="Id"><?= e($ret["produto_id"]) ?></td>
            <td data-titulo="Nome"><?= e($ret["produto_nome"]) ?></td>
            <td data-titulo="Tipo Produto"><?= e($ret["tipo_produto_nome"]) ?></td>
            <td data-titulo="Tipo"><?= e($ret["tipo_descricao"]) ?></td>
            <td data-titulo="Qtde."><?= e(\bd\Formatos::moeda($ret["quantidade"]) . ' ' . \modelo\Produto::UNIDADES_MEDIDAS[$ret["unidade_medida"]]) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>