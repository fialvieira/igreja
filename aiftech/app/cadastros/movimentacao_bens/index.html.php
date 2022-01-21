<?php $template = new \templates\Igreja() ?>

    <?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
    <?php $template->fimCss() ?>

    <?php $template->iniMain() ?>

    <div class="container-grid">
        <h1>Movimentação de Bens</h1>
        <div class="qbe">
            <div class="campos campos-horizontais">
                <div class="campo">
                    <div class="controle">
                        <input type="text" id="txt_pesquisa" onkeyup="filtra(event)">
                    </div>
                    <div class="mensagem"></div>
                </div>
                <a class="botao no-max" onclick="pesquisa();">Pesquisar</a>
                <a class="novo" href="movimentacao_bem.php"></a>
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