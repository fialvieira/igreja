<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="associacao.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
<h1><a onclick="voltar()">Associações</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                <div class="campo">
                    <div class="rotulo">
                        <label>Sigla</label>
                    </div>
                    <div class="controle">
                        <input type="text"
                               id="sigla"
                               required
                               maxlength="10"
                               value="<?= e($retorno->getSigla()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Descrição</label>
                    </div>
                    <div class="controle">
                        <input type="text" id="descricao" value="<?= e($retorno->getDescricao()) ?>">
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
<script src="associacao.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>