<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <div class="container-grid">
        <h1>
            <div>Relatórios / Membros</div>
            <div id="info">
                <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
                   title="Visualizar Manual."></a>
            </div>
        </h1>
        <div class="qbe">
            <div class="campos campos-horizontais">
                <div class="campo">
                    <div class="controle">
                        <select id="sel_status">
                            <option value="" selected>Status</option>
                            <option value="A">Ativo</option>
                            <option value="I">Inativo</option>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="controle">
                        <select id="quorum" onchange="pesquisa()">
                            <option value="" selected>Quórum</option>
                            <option value="S">Sim</option>
                            <option value="N">Não</option>
                        </select>
                        <div class="mensagem"></div>
                    </div>
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