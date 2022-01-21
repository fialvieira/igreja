<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
    <link rel="stylesheet" href="dashboard.css">
<?php $template->fimCss() ?>
<?php $template->iniJs() ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="dashboard.js"></script>
<?php $template->fimJs() ?>
<?php $template->iniMain() ?>
    <div class="container" id="ctn_cards">
        <div>
            <div class="card">
                <h1>Receitas x Despesas - Realizados &nbsp;<span id="lbl_card"></span></h1>
                <div class="campos">
                    <div class="campo">
                        <div class="rotulo">
                            <label></label>
                        </div>
                        <div class="controle" id="ctrl_orcamento">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $template->fimMain() ?>
<?php $template->renderiza() ?>