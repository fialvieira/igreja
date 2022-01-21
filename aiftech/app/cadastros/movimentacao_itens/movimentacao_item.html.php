<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="movimentacao_item.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<!--<h1><a href="ndex.php">Movimentação Itens</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>-->
<h1><a onclick="voltar()">Movimentação Itens</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="movimentacao_itens">
                <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>"> 
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
                        <label>Devolvido</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="devolvido" 
                               
                               required
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getDevolvido())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Membro</label>
                    </div>
                    <div class="controle">
                        <select id="membro_id"
                                data-tabela="membros"
                                data-codigo="id"
                                data-descricao="nome"
                                >   
                            <option value=""></option>     
                        <?php foreach ($membros as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getMembroId())))? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Item</label>
                    </div>
                    <div class="controle">
                        <select id="item_id"
                                data-tabela="itens"
                                data-codigo="id"
                                data-descricao="titulo"
                                >   
                            <option value=""></option>     
                        <?php foreach ($itens as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getItemId())))? "selected" : "" ?>><?= ucwords($tbl["titulo"]) ?>
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
    <script src="movimentacao_item.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>