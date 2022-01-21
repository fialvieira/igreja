<table>
    <thead>
    <tr>
        <th class="centro">ID</th>
        <th class="">Nome</th>
        <th class="">Descrição</th>
        <th class="">Banco</th>
        <th class="">Agência</th>
        <th class="">Número</th>
        <th class="">Variação</th>
        <th class="">Tipo Conta</th>
        <th class="">Tipo Aplicação</th>
        <th>Saldo Inicial</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($retorno as $ret): ?>
        <tr data-id="<?= e(\bd\Formatos::inteiro($ret["id"])) ?>">
            <td data-titulo="ID" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Descrição" class=""><?= e($ret["descricao"]) ?></td>
            <td data-titulo="Banco" class=""><?= e($ret["banco_descricao"]) ?></td>
            <td data-titulo="Agência" class=""><?= e($ret["agencia"]) ?></td>
            <td data-titulo="Número" class=""><?= e($ret["numero"]) ?></td>
            <td data-titulo="Variação" class=""><?= e($ret["variacao"]) ?></td>
            <td data-titulo="Tipo Conta" class=""><?= e($ret["tipo_conta_descricao"]) ?></td>
            <td data-titulo="Tipo Aplicação" class=""><?= e($ret["tipo_aplicacao_descricao"]) ?></td>
            <td data-titulo="Saldo Inicial" class=""><?= e(\bd\Formatos::moeda($ret["saldo_inicial"])) ?></td>
            <td class="acoes">
                <div>
                    <?php if (Aut::temPermissao(Aut::$modulos['CONTAS_BANCARIAS'], \modelo\Permissao::REWRITE)): ?>
                        <a id="a_acao" class="alterar" href="contas_financeira.php?id=<?= $ret["id"] ?>"></a>
                        <a id="h_acao" title="<?= e($ret['ativo'] === 'S') ? 'Desativar conta' : 'Ativar conta' ?>"
                           class="<?= e($ret['ativo'] === 'S') ? 'ligado' : 'desligado' ?>"
                           onclick="alteraAtivo(this)"></a>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>