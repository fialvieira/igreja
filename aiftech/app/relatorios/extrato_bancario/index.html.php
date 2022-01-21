<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
<div class="container-grid">
    <h1>
        <div>Relatórios / Extrato Bancário</div>
        <div id="info">
            <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
               title="Visualizar Manual."></a>
        </div>
    </h1>
    <div class="qbe">
        <div class="campos campos-horizontais">
            <div class="campo">
                <div class="rotulo">
                    <label>Banco</label>
                </div>
                <div class="controle">
                    <select id="banco" onchange="carregaContas(this)">
                        <option value=""></option>
                        <?php foreach ($bancos as $banco): ?>
                            <option value="<?= hs($banco['id']) ?>"><?= e($banco['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mensagem"></div>
            </div>
            <div class="campo">
                <div class="rotulo">
                    <label>Conta Bancária</label>
                </div>
                <div class="controle">
                    <select id="conta" onchange="" required>
                        <option value=""></option>
                        <?php foreach ($contas as $conta): ?>
                            <option data-banco="<?= hs($conta['banco_id']) ?>" value="<?= hs($conta['id']) ?>"><?= e($conta['nome']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mensagem"></div>
            </div>
            <div class="campo">
                <div class="rotulo">
                    <label>Período</label>
                </div>
                <div class="controle">
                    <select id="periodo" required>
                        <option value="000000">Últimos 30 dias</option>
                        <?php foreach ($periodos as $periodo): ?>
                            <option value="<?= e($periodo['valor']) ?>"><?= e($periodo['descricao']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mensagem"></div>
            </div>
            <a class="botao" onclick="pesquisa('P')">Gerar Relatório</a>
            <a class="botao" onclick="pesquisa('I')">Imprimir PDF</a>
        </div>
    </div>
    <div id="ctn_totalizador">
        <span id="total_registros"></span>
    </div>
    <div class="grid"></div>
</div>

<!--Janela com os arquivos de cada lançamento-->
<div id="j_arquivos" class="modal">
  <header>
    <h2>Detalhes <span id="spn_arquivos"></span></h2>
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