<table id="tbl_fornecedores">
    <thead>
    <tr>
        <th>CNPJ</th>
        <th>Fornecedor</th>
        <th>Telefone</th>
        <th>E-mail</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $k => $v): ?>
        <tr>
            <td data-titulo="CNPJ"><?= e(\bd\Formatos::cnpjApp($v['cnpj'])) ?></td>
            <td data-titulo="Fornecedor"><?= e($v['nome_fantasia']) ?></td>
            <td data-titulo="Telefone"><?= e($v['telefone']) ?></td>
            <td data-titulo="E-mail"><?= e($v['email']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>