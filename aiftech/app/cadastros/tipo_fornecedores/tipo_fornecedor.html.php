<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="tipo_fornecedor.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>
  <div>
    <a onclick="voltar()">Tipo de Fornecedores</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> 
  </div>
  <div id="info">
    <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank" title="Visualizar Manual."></a>
  </div>
</h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="tipo_fornecedores">
                <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>"> 
                <div class="campo">
                    <div class="rotulo">
                        <label>Descrição</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="descricao" 
                               required
                               maxlength="50"
                               value="<?= e($retorno->getDescricao()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <input type="hidden" id="user_id" value="<?= e(\bd\Formatos::inteiro($retorno->getUserId())) ?>"> 
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
<script src="tipo_fornecedor.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>