<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <div class="container-grid">
        <h1>
            <div>Contas a Pagar</div>
            <div id="info">
                <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
                   title="Visualizar Manual."></a>
            </div>
        </h1>
        <div class="qbe" id="qbe">
            <div class="campos campos-horizontais">
                <div class="campo">
                    <div class="rotulo">
                        <label>Data Inicial</label>
                    </div>
                    <div class="controle">
                        <input type="text" class="data" id="data_inicial">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Data Final</label>
                    </div>
                    <div class="controle">
                        <input type="text" class="data" id="data_final">
                        <div class="mensagem"></div>
                    </div>
                </div>

                <div class="campo">
                    <div class="rotulo">
                        <label>Solicitante</label>
                    </div>
                    <div class="controle">
                        <input type="text" id="solicitante"
                               onblur="validaCombo(this, 'pastor')">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <a class="botao" onclick="pesquisa();">Pesquisar</a>
                <a class="botao" onclick="limpa();">Limpar</a>
            </div>
        </div>
        <div id="ctn_totalizador">
            <span id="total_registros"></span>
        </div>
        <div class="grid"></div>
    </div>

    <div id="j_solicitante" class="combo flutuante">
        <div id="grid_solicitante">
            <table>
                <tbody>
                <?php foreach ($solicitantes as $k => $v): ?>
                    <tr data-id="<?= hs($v["solicitante_id"]) ?>"
                        data-nome="<?= hs($v['nome']) ?>"
                        data-campo="solicitante">
                        <td data-value="<?= e($v["nome"]) ?>"><?= e($v["nome"]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
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