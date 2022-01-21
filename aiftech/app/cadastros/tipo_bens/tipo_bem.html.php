<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="tipo_bem.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>
  <div>
    <a onclick="voltar()">Tipo de Bens</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> 
  </div>
  <div id="info">
    <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank" title="Visualizar Manual."></a>
  </div>
</h1>
<div class="container">
  <div>
    <div class="card">
      <div class="campos">
        <input type="hidden" id="tabela" value="tipo_bens">
        <input type="hidden" id="id" value="<?= e($retorno->getId()) ?>"> 
        <div class="campo">
          <div class="rotulo">
            <label>Nome</label>
          </div>
          <div class="controle">
            <input type="text" 
                   class="texto" 
                   id="nome" 
                   required
                   maxlength="80"
                   value="<?= e($retorno->getNome()) ?>">
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
<script src="tipo_bem.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>