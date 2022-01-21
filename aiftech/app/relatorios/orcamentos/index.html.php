<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <div class="container-grid">
        <h1>
            <div>Relatórios / Acompanhamento Orçamento</div>
<!--            <div id="info">
                <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
                   title="Visualizar Manual."></a>
            </div>-->
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
                            <option value="<?= hs($ano['ano']) ?>" <?= ($ano['ano'] == $year)? 'selected' : '' ?>><?= e($ano['ano']) ?></option>
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
                <a class="botao" onclick="pesquisa();">Pesquisar</a>
            </div>
        </div>
        <div class="grid"></div>
    </div>
<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="index.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>