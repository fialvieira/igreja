<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <div class="container-grid">
        <h1>
            <div>Relatórios / Aniversariantes</div>
            <div id="info">
                <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
                   title="Visualizar Manual."></a>
            </div>
        </h1>
        <div class="qbe">
            <div class="campos campos-horizontais">
                <div class="campo">
                    <div class="rotulo">
                        <label>Mês</label>
                    </div>
                    <div class="controle">
                        <select id="mes" onchange="pesquisa()">
                            <option value=""></option>
                            <?php foreach (mesPorExtenso(null) as $k => $v): ?>
                                <option value="<?= e($k) ?>"><?= e($v) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mensagem"></div>
                </div>
                <a class="botao" onclick="pesquisa()">Gerar Relatório</a>
            </div>
        </div>
        <div id="ctn_totalizador">
            <span id="total_registros"></span>
        </div>
        <div class="grid"></div>
    </div>
<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="index.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>