<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
    <link rel="stylesheet" href="movimentacao_membro.css">
<?php $template->fimCss() ?>
<?php $template->iniMain() ?>
    <h1>
        <div>
            <a onclick="voltar()">Membros</a> / Movimentação de Membros
        </div>
        <div id="info">
            <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
               title="Visualizar Manual."></a>
        </div>
    </h1>
    <div class="container">
<?php if (Aut::temPermissao(Aut::$modulos['MEMBROS'], \modelo\Permissao::WRITE)): ?>
    <div>
        <div class="card">
            <h1>Movimentação: <?= e($retorno->getNome()) ?></h1>
            <div class="campos">
                <input type="hidden" id="membro_id" value="<?= e($retorno->getId()) ?>">
                <input type="hidden" id="nome_membro" value="<?= e($retorno->getNome()) ?>">
                <div class="campo">
                    <div class="rotulo">
                        <label>Ata Nº</label>
                    </div>
                    <div class="controle">
                        <select id="ata">
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
                        <label>Carta Nº</label>
                    </div>
                    <div class="controle">
                        <select id="carta" onchange="setDataRecebimento(this)">
                            <option value=""></option>
                            <?php foreach ($cartas as $k => $v): ?>
                                <option value="<?= e($v['id']) ?>"><?= e($v['num']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo</label>
                    </div>
                    <div class="controle">
                        <select id="tipo_movimentacao" required>
                            <option value=""></option>
                            <?php foreach ($tipo_mov_membro as $k => $v): ?>
                                <option value="<?= e($v['id']) ?>"><?= e($v['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Data Recebimento</label>
                    </div>
                    <div class="controle">
                        <input type="text" id="data_recebimento" class="data">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Observação</label>
                    </div>
                    <div class="controle">
                        <textarea id="observacao" cols="50" rows="30"></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label id="rotulo_texto">Anexar Arquivo</label>
                    </div>
                    <div class="controle arquivo">
                        <label class="file rotulo_arq" for="arquivo" title="Upload de arquivo."></label>
                        <input type="file" id="arquivo" name="arquivo" onchange="seleciona_arquivo(this)">
                        <div class="mensagem"></div>
                        <div id="ctn_arquivos"></div>
                    </div>
                </div>
            </div>
            <div class="botoes">
                <a class="botao" onclick="salva('<?= e($id) ?>')">Salvar</a>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
<?php endif; ?>
    <div id="grid"></div>
<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script>localStorage.setItem('membro_id', <?= e($id) ?>)</script>
    <script src="movimentacao_membro.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>