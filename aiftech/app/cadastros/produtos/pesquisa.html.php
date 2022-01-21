<table>
    <thead>
    <tr>
        <th class="centro">ID</th>
        <th>Nome</th>
        <th>Descrição</th>
        <th>Unidade Medida</th>
        <th>Categoria</th>
        <th>Tipo</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr>
            <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
            <td data-titulo="Nome"><?= e($ret["nome"]) ?></td>
            <td data-titulo="Descrição"><?= e($ret["descricao"]) ?></td>
            <td data-titulo="Unidade Medida"><?= e(($ret["unidade_medida"] != '') ? \modelo\Produto::UNIDADES_MEDIDAS[$ret["unidade_medida"]] : '') ?></td>
            <td data-titulo="Categoria"><?= e(($ret["tipo"] == 'P') ? 'Produto' : 'Serviço') ?></td>
            <td data-titulo="Tipo"><?= e($ret["tipo_produto"]) ?></td>
            <?php if (!$permitido): ?>
                <td data-titulo="Ativo"><?= e(($ret["ativo"] == "S") ? "Sim" : "Não") ?></td>
            <?php else: ?>
                <td class="acoes">
                    <div>
                        <a id="a_fornecedores" class="detalhe" title="Fornecedores" onclick="abreFornecedores('<?= $ret['id'] ?>')"></a>
                        <a id="a_acao" class="alterar" title="Alterar dados"
                           href="produto.php?id=<?= $ret["id"] ?>"></a>
                        <a class="<?= ($ret["ativo"] == "S") ? "ligado" : "desligado" ?>"
                           title="<?= ($ret["ativo"] == "S") ? "Desativar" : "Ativar" ?>"
                           data-id="<?= e($ret["id"]) ?>"
                           onclick="liga_desliga(this)"></a>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>