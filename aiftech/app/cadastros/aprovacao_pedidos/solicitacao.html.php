<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="solicitacao.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <h1>
        <div>
            <a onclick="voltar()">Aprovação Pedidos</a> / <?= (!$retorno->getId()) ? "Novo" : "Alterar" ?>
        </div>
        <div id="info">
            <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
               title="Visualizar Manual."></a>
        </div>
    </h1>
    <div class="container">
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
                                    id="justificativa" <?= $disabled ?>><?= e($retorno->getJustificativa()) ?></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Orçamentos Selecionados</label>
                    </div>
                    <div class="controle orcamento">
                        <div id="ctn_itens"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Orçamentos</label>
                    </div>
                    <div class="controle orcamento">
                        <div id="ctn_orcamentos" class="margem-superior"></div>
                    </div>
                </div>
            </div>
            <div class="botoes">
                <?php if ($mostra_botoes): ?>
                    <a class="botao verde" id="btn_aprovar" onclick="salva('A')">Aprovar</a>
                    <a class="botao vermelho" id="btn_recusar" onclick="salva('R')">Recusar</a>
                <?php endif; ?>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
    <div id="j_observacao" class="modal">
        <header>
            <h2>Observação</h2>
            <a class="fechar" title="Fechar janela"></a>
        </header>
        <section>
            <div id="detalhes" class="campos">
                <div class="campo">
                    <div class="rotulo">
                        <label></label>
                    </div>
                    <div class="controle">
                        <textarea id="observacao" placeholder="Digite o texto aqui" cols="10" rows="6"></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
            </div>
        </section>
        <div class="botoes">
            <a class="botao" onclick="salvaObservacao('observacao')">Salvar</a>
            <a class="botao" onclick="modal.fecha()">Voltar</a>
        </div>
    </div>
<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="solicitacao.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>