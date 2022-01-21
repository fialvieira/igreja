<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
<h1>
    <div>Solicitação de Compra</div>
    <div id="info">
        <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank" title="Visualizar Manual."></a>
    </div>
</h1> 
<div class="container-grid">
    <div class="qbe">
        <div class="campos campos-horizontais">
            <div class="campo">
                <div class="controle">
                    <input type="text" id="txt_pesquisa" onkeyup="filtra(event)">
                </div>
                <div class="mensagem"></div>
            </div>
            <a class="botao no-max" onclick="filtra();">Pesquisar</a>
            <?php if ($permitido): ?>
                <a class="novo" href="solicitacao.php"></a>
            <?php endif; ?>       
        </div>
    </div>
    <div id="ctn_totalizador">
        <span id="total_registros"></span>
    </div>
    <div class="grid"></div>
</div>

<!--Janela com os orçamentos de cada solicitação-->
<div id="j_arquivos" class="modal">
    <header>
        <h2>Orçamentos <span id="spn_arquivos"></span></h2>
        <a class="fechar" title="Fechar janela"></a>
    </header>
    <section>
        <div id="detalhes_grid"></div>
    </section>
    <div class="botoes">
        <a class="botao" onclick="modal.fecha()">Voltar</a>
    </div>
</div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script src="index.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>