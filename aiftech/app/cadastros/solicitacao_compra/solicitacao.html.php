<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="solicitacao.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
<h1>
    <div>
        <a onclick="voltar()">Solicitação de Compra</a> / <?= (!$retorno->getId()) ? "Novo" : "Alterar" ?>
    </div>
    <div id="info">
        <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
           title="Visualizar Manual."></a>
    </div>
</h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="situacao" value="<?= e($retorno->getSituacao()) ?>">
                <div class="campo">
                    <div class="rotulo">
                        <label>Nº da Compra</label>
                    </div>
                    <div class="controle">
                        <input type="text"
                               class="inteiro"
                               id="id"
                               disabled
                               value="<?= e($retorno->getId()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Solicitante</label>
                    </div>
                    <div class="controle">
                        <input type="hidden" id="solicitante"
                               value="<?= e(($retorno->getSolicitante()) ? $retorno->getSolicitante() : $solicitante['id']) ?>">
                        <input type="text"
                               class=""
                               id="nome"
                               disabled
                               value="<?= e(($retorno->getSolicitanteNome()) ? $retorno->getSolicitanteNome() : $solicitante['nome']) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Data</label>
                    </div>
                    <div class="controle">
                        <input type="text"
                               class="data"
                               id="data_solicitacao"
                               maxlength="10"
                               required
                               <?= $disabled ?>
                               value="<?= e(\bd\Formatos::dataApp($retorno->getDtSolicitacao())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Justificativa</label>
                    </div>
                    <div class="controle">
                        <textarea
                            id="justificativa" <?= $disabled ?> required><?= e($retorno->getJustificativa()) ?></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Conta</label>
                    </div>
                    <div class="controle">
                        <select id="conta" required>
                            <option></option>
                            <?php foreach ($contas as $conta): ?>
                                <option value="<?= hs($conta['id']) ?>" <?= ($conta['id'] == $retorno->getCategoriaFinanceira() ? 'selected' : '') ?>><?= e($conta['num'] . ' - ' . $conta['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <?php if ($disabled == ''): ?>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Produto à inserir</label>
                        </div>
                        <div class="controle">
                            <input type="text" <?= $disabled ?> id="produto">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="campo">
                    <div class="rotulo">
                        <label>Itens</label>
                    </div>
                    <div class="controle">
                        <div id="ctn_itens"></div>
                    </div>
                </div>
            </div>
            <div class="botoes">
                <?php if ($disabled == ''): ?>
                    <a class="botao" id="salvar" onclick="salva()">Salvar</a>
                <?php endif; ?>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
</div>

<!--Janela com lista dos produtos-->
<div id="j_produtos" class="combo flutuante">
    <div>
        <table>
            <tbody>
                <?php foreach ($produtos as $produto) : ?>
                    <tr>
                        <td class="" data-value="<?= hs($produto["id"]) ?>"><?= e($produto["nome"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script src="solicitacao.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>