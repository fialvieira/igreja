<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="movimentacao_bem.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<!--<h1><a href="ndex.php">Movimentação de Bens</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>-->
<h1><a onclick="voltar()">Movimentação de Bens</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="movimentacao_bens">
                <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>"> 
                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="tipo" 
                               
                               
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getTipo())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Quantidade</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="quantidade" 
                               
                               
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getQuantidade())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Saldo</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="saldo" 
                               
                               
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getSaldo())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Motivo</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="motivo" 
                               
                               
                               maxlength="50"
                               value="<?= e($retorno->getMotivo()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Bem</label>
                    </div>
                    <div class="controle">
                        <select id="bem_id"
                                data-tabela="bens"
                                data-codigo="id"
                                data-descricao="nome"
                                >   
                            <option value=""></option>     
                        <?php foreach ($bens as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getBemId())))? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                        <input type="hidden" id="user_id" value="<?= e(\bd\Formatos::inteiro($retorno->getUserId())) ?>"> 
                        <input type="hidden" id="empresa_id" value="<?= e(\bd\Formatos::inteiro($retorno->getEmpresaId())) ?>"> 
                        <input type="hidden" id="created" value="<?= e(\bd\Formatos::dataHoraApp($retorno->getCreated())) ?>"> 
                        <input type="hidden" id="modified" value="<?= e(\bd\Formatos::dataHoraApp($retorno->getModified())) ?>"> 
            </div>
            <div class="botoes">
                <a class="botao" onclick="salva()">Salvar</a>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
</div>

    <?php $template->fimMain() ?>

    <?php $template->iniJs() ?>
    <script src="movimentacao_bem.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>