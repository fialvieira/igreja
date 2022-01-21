<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
<link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>
<?php $template->iniMain() ?>
<div class="container-grid">
    <h1>
        <div>Planejamento Orçamentário</div>
        <div id="info">
            <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank" title="Visualizar Manual."></a>
        </div>
    </h1>
    <div class="qbe">
        <div class="campos campos-horizontais">
            <div class="campo">
                <div class="rotulo">
                    <label>Ano</label>
                </div>
                <div class="controle">
                    <select id="ano" required>
                        <?php foreach ($anos as $ano) : ?>
                            <option value="<?= hs($ano['ano']) ?>" <?= ($ano['ano'] == $year) ? 'selected' : '' ?>><?= e($ano['ano']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mensagem"></div>
            </div>
            <div class="campo">
                <div class="rotulo">
                    <label>Mês</label>
                </div>
                <div class="controle">
                    <select id="mes">
                        <option value=""></option>
                        <?php foreach ($meses as $k => $v) : ?>
                            <option value="<?= hs(str_pad($k, 2, '0', STR_PAD_LEFT)) ?>"><?= e($v) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mensagem"></div>
            </div>
            <div class="campo">
                <div class="controle">
                    <input type="text" id="txt_pesquisa" onkeyup="filtra(event)">
                </div>
                <div class="mensagem"></div>
            </div>

            <a class="botao" onclick="pesquisa();">Pesquisar</a>
            <a class="botao" href="../../relatorios/orcamentos/index.php">Relatório</a>
            <?php if ($permitido): ?>
                <a class="novo" href="planejamento_orcamentario.php"></a>
                <a class="botao" onclick="replicar();">Replicar</a>
            <?php endif; ?>
        </div>
    </div>
    <div id="ctn_totalizador">
        <span id="total_registros"></span>
    </div>
    <div class="grid"></div>
</div>

<div id="j_replicar" class="modal">
    <header>
        <h2>Replicar planejamentos?</h2>
        <a class="fechar" title="Fechar janela"></a>
    </header>
    <section>
        <div class="campos">
            <div class="campo">
                <div class="rotulo">
                    <label>De Ano</label>
                </div>
                <div class="controle">
                    <select id="ano_de" required>
                        <?php foreach ($anos as $ano) : ?>
                            <option value="<?= hs($ano['ano']) ?>"><?= e($ano['ano']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="mensagem"></div>
                </div>
            </div>
            <div class="campo">
                <div class="rotulo">
                    <label>De Mês</label>
                </div>
                <div class="controle">
                    <select id="mes_de">
                        <option value=""></option>
                        <?php foreach ($meses as $k => $v) : ?>
                            <option value="<?= hs(str_pad($k, 2, '0', STR_PAD_LEFT)) ?>"><?= e($v) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="mensagem"></div>
                </div>
            </div>
            <div class="campo">
                <div class="rotulo">
                    <label>Para Ano</label>
                </div>
                <div class="controle">
                    <select id="ano_para" required>
                        <option></option>
                        <?php foreach ($anos as $ano) : ?>
                            <option value="<?= hs($ano['ano']) ?>"><?= e($ano['ano']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="mensagem"></div>
                </div>
            </div>
            <div class="campo">
                <div class="rotulo">
                    <label>Para Mês</label>
                </div>
                <div class="controle">
                    <select id="mes_para">
                        <option value=""></option>
                        <?php foreach ($meses as $k => $v) : ?>
                            <option value="<?= hs(str_pad($k, 2, '0', STR_PAD_LEFT)) ?>"><?= e($v) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="mensagem"></div>
                </div>
            </div>
        </div>
    </section>
    <div class="botoes">
        <a class="botao" id="btn_cancelar" onclick="replica()">Confirmar</a>
        <a class="botao" onclick="modal.fecha()">Voltar</a>
    </div>
</div>

<?php $template->fimMain() ?>
<?php $template->iniJs() ?>
<script src="index.js"></script>
<?php $template->fimJs() ?>
<?php $template->renderiza() ?>