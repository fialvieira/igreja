<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="ata_tipo.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>
    <div>
        <a onclick="voltar()">Tipo de Atas</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> 
    </div>
    <div id="info">
        <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank" title="Visualizar Manual."></a>
    </div>
</h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="id" value="<?= e($retorno->getId()) ?>"> 
                <div class="campo">
                    <div class="rotulo">
                        <label>Descrição</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="descricao" 
                               required
                               maxlength="150"
                               value="<?= e($retorno->getDescricao()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Texto Inicial Padrão</label>
                    </div>
                    <div class="controle">
                        <textarea class="texto" 
                                  id="texto_padrao" 
                                  required
                                  rows="5"><?= e($retorno->getTextoPadrao()) ?></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Registra Cartório?</label>
                    </div>
                    <div class="controle">
                        <select id="cartorio" required>
                            <option></option>
                            <?php foreach ($arrCartorio as $k => $v): ?>
                            <option value="<?= $k ?>" <?= ($k == $retorno->getCartorio())? 'selected' : '' ?>><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
            </div>
            <div class="legenda">
                <span>Para incluir a descrição do tipo da ata utilizar a tag #TIPO. </span>
                <span>Para incluir nome da igreja utilizar a tag #IGREJA. </span>
                <span>Para incluir a data da ata por extenso utilizar a tag #DATA_EXTENSO. </span>
                <span>Para incluir a data da ata no formato dd/mm/aaaa utilizar a tag #DATA. </span>
                <span>Para incluir o endereço da igreja utilizar a tag #ENDERECO. </span>
                <span>Para incluir nome do presidente da Assambleia utilizar o código #PRESIDENTE. </span>
                <span>Para incluir nome do(a) secretário(a) da Assambleia utilizar o código #SECRETARIA. </span>
            </div>
            <div class="botoes">
                <a class="botao" id="salvar" onclick="salva()">Salvar</a>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
</div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script src="ata_tipo.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>