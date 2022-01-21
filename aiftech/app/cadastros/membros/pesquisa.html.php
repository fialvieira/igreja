<table>
    <thead>
    <tr>
        <th class="">Nome</th>
        <th>Frequência</th>
        <th>Quorum</th>
        <th class="">CPF</th>
        <th class="">Email</th>
        <th class="">Fone</th>
        <th class="">Celular</th>
        <th class="">Tipo</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($retorno as $ret):
        $freq = new \modelo\Frequencia($ret["frequencia_id"]);
        $quorum = (($ret["datanascimento"]) != '') ? \modelo\Membro::isQuorum($freq->getQuorum(), $ret["idade_quorum"],
            \bd\Formatos::dataApp($ret["datanascimento"])) : '';
        ?>
        <tr>
            <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
            <td data-titulo="Fequência"><?= e($freq->getFrequencia()) ?></td>
            <td data-titulo="Quorum"><?= e(($quorum) ? "Sim" : "Não") ?></td>
            <td data-titulo="CPF" class=""><?= e(\bd\Formatos::cpfApp($ret["cpf"])) ?></td>
            <td data-titulo="Email" class=""><?= e($ret["email"]) ?></td>
            <td data-titulo="Fone" class=""><?= e(\bd\Formatos::telefoneApp($ret["fone"])) ?></td>
            <td data-titulo="Celular" class=""><?= e(\bd\Formatos::telefoneApp($ret["cel"])) ?></td>
            <td data-titulo="Tipo" class=""><?= e(\modelo\Membro::TIPOS[$ret["tipo"]]) ?></td>
            <td class="acoes">
                <div>
                    <a id="d_acao" class="detalhe" title="Detalhar" onclick="abreDetalhes('<?= $ret["id"] ?>')"></a>
                    <?php if (Aut::temPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::REWRITE)): ?>
                        <a id="a_acao" class="alterar" title="Alterar dados" href="membro.php?id=<?= $ret["id"] ?>"></a>
                        <a id="p_acao" class="parentesco" title="Ajustar parentesco"
                           href="parentesco.php?id=<?= $ret["id"] ?>"></a>
                    <?php endif; ?>
                    <a id="m_acao" class="movimentacao_membro" title="Movimentação"
                       href="<?= SITE ?>app/cadastros/movimentacao_membros/movimentacao_membro.php?id=<?= $ret["id"] ?>"></a>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>