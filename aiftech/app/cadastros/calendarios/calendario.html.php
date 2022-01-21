<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="calendario.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<!--<h1><a href="ndex.php">Calendarios</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>-->
<h1><a onclick="voltar()">Calendarios</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="calendarios">
                <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>"> 
                <div class="campo">
                    <div class="rotulo">
                        <label>Datainicio</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="data" 
                               id="datainicio" 
                               
                               
                               maxlength="1"
                               value="<?= e(\bd\Formatos::dataHoraApp($retorno->getDatainicio())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Assunto</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="assunto" 
                               
                               
                               maxlength="50"
                               value="<?= e($retorno->getAssunto()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Datafim</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="data" 
                               id="datafim" 
                               
                               
                               maxlength="1"
                               value="<?= e(\bd\Formatos::dataHoraApp($retorno->getDatafim())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Descricao</label>
                    </div>
                    <div class="controle">
                        <textarea class="memo" 
                               id="descricao" 
                               
                               maxlength="65535"><?= e($retorno->getDescricao()) ?></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
                        <input type="hidden" id="empresa_id" value="<?= e(\bd\Formatos::inteiro($retorno->getEmpresaId())) ?>"> 
                        <input type="hidden" id="user_id" value="<?= e(\bd\Formatos::inteiro($retorno->getUserId())) ?>"> 
                        <input type="hidden" id="modified" value="<?= e(\bd\Formatos::dataHoraApp($retorno->getModified())) ?>"> 
                        <input type="hidden" id="created" value="<?= e(\bd\Formatos::dataHoraApp($retorno->getCreated())) ?>"> 
                <div class="campo">
                    <div class="rotulo">
                        <label>Diatodo</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="diatodo" 
                               
                               
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getDiatodo())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>COR</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="cor" 
                               
                               
                               maxlength="45"
                               value="<?= e($retorno->getCor()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
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
    <script src="calendario.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>