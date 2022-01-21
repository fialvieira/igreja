<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <div class="container-grid">
        <h1>
            <div>Relatórios / Movimentação Membros</div>
            <div id="info">
                <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
                   title="Visualizar Manual."></a>
            </div>
        </h1>
        <div class="qbe">
            <div class="campos campos-horizontais">
                <div class="campo">
                    <div class="rotulo">
                        <label>Membro</label>
                    </div>
                    <div class="controle">
                        <input type="text" id="membro"
                               onblur="validaCombo(this)">
                        <div class="mensagem"></div>
                    </div>
                </div>

                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo Movimentação</label>
                    </div>
                    <div class="controle">
                        <select id="tipo_movimentacao">
                            <option value=""></option>
                            <?php foreach ($tipo_movimentacao as $k => $v): ?>
                                <option value="<?= e($v['id']) ?>"><?= e($v['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>

                <div class="campo">
                    <div class="rotulo">
                        <label>Ata</label>
                    </div>
                    <div class="controle">
                        <select id="ata_id">
                            <option value=""></option>
                            <?php foreach ($atas as $k => $v): ?>
                                <option value="<?= e($v['id']) ?>"><?= e($v['num']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>

                <div class="campo">
                    <div class="rotulo">
                        <label>Data Inicial</label>
                    </div>
                    <div class="controle">
                        <input type="text"
                               class="data"
                               id="data_inicial"
                               maxlength="10">
                        <div class="mensagem"></div>
                    </div>
                </div>

                <div class="campo">
                    <div class="rotulo">
                        <label>Data Final</label>
                    </div>
                    <div class="controle">
                        <input type="text"
                               class="data"
                               id="data_final"
                               maxlength="10">
                        <div class="mensagem"></div>
                    </div>
                </div>

                <a class="botao" onclick="pesquisa();">Gerar Relatório</a>
            </div>
        </div>
        <div class="grid"></div>
    </div>

    <div id="j_membros" class="combo flutuante">
        <div id="grid_membros">
            <table>
                <tbody>
                <?php foreach ($membros as $key => $value): ?>
                    <tr data-id="<?= hs($value['id']) ?>"
                        data-nome="<?= hs($value['nome']) ?>"
                        data-campo="membro">
                        <td data-value="<?= hs($value['id']) ?>"><?= e($value['nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="index.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>