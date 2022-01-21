<table>
    <thead>
    <tr>
        <th class="">Nome Fantasia</th>
        <th class="">Razão Social</th>
        <th class="">Cnpj</th>
        <th class="">Email</th>
        <th class="">Telefone</th>
        <th class="">Celular</th>
        <th class="">Tipo</th>
        <?php if (!$permitido): ?>
            <th>Ativo</th>
        <?php else: ?>
            <th></th>
        <?php endif; ?>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr data-id="<?= e($ret["id"]) ?>">
            <td data-titulo="Nome Fantasia" class=""><?= e($ret["nome_fantasia"]) ?></td>
            <td data-titulo="Razão Social" class=""><?= e($ret["razao_social"]) ?></td>
            <td data-titulo="Cnpj" class=""><?= e(\bd\Formatos::cnpjApp($ret["cnpj"])) ?></td>
            <td data-titulo="Email" class=""><?= e(\bd\Formatos::email($ret["email"])) ?></td>
            <td data-titulo="Telefone" class=""><?= e(\bd\Formatos::telefoneApp($ret["telefone"])) ?></td>
            <td data-titulo="Celular" class=""><?= e(\bd\Formatos::telefoneApp($ret["telefone2"])) ?></td>
            <td data-titulo="Tipo" class=""><?= e($ret["tipo_descricao"]) ?></td>
            <?php if (!$permitido): ?>
                <td data-titulo="Ativo"><?= e(($ret["ativo"] == "S") ? "Sim" : "Não") ?></td>
            <?php else: ?>
                <td class="acoes">
                    <div>
                        <a id="a_acao" class="alterar" title="Alterar dados"
                           href="fornecedor.php?id=<?= $ret["id"] ?>"></a>
                        <?php if ($permitido): ?>
                            <a class="<?= ($ret["ativo"] == "S") ? "ligado" : "desligado" ?>"
                               title="<?= ($ret["ativo"] == "S") ? "Desativar fornecedor" : "Ativar fornecedor" ?>"
                               onclick="liga_desliga(this)"></a>
                        <?php endif; ?>
                    </div>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>