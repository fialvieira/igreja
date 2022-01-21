<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <div class="container-grid">
        <h1>
            <div>Relatórios / Relatório Conselho Diretor</div>
            <div id="info">
                <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
                   title="Visualizar Manual."></a>
            </div>
        </h1>
        <div class="qbe">
            <div class="campos campos-horizontais">
                <div class="campo">
                    <div class="rotulo">
                        <label>Ano</label>
                    </div>
                    <div class="controle">
                        <select id="ano" onchange="carregaMeses(this)" required>
                            <option value=""></option>
                            <?php foreach ($anos as $k => $v): ?>
                                <option value="<?= e($v['ANO']) ?>"><?= e($v['ANO']) ?></option>
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
                        <select id="mes" required>
                            <option value=""></option>
                            <?php foreach (mesPorExtenso(null) as $k => $v): ?>
                                <option value="<?= e($k) ?>"><?= e($v) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mensagem"></div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Movimentação</label>
                    </div>
                    <div class="controle">
                        <select id="movimentacao">
                            <option value=""></option>
                            <option value="E">Entrada</option>
                            <option value="S">Saída</option>
                        </select>
                    </div>
                    <div class="mensagem"></div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo</label>
                    </div>
                    <div class="controle">
                        <select id="tipo" required>
                            <option value=""></option>
                            <option value="A">Analítico</option>
                            <option value="S">Sintético</option>
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