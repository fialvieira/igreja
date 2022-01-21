<?php  /* @var $usuario \modelo\Usuario */  ?>

<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="usuario.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1><a href="index.php">Usuários</a> / Alterar</h1>
<div class="container">
  <div>
    <div class="card">
      <div class="campos">
        <input type="hidden" id="codigo" value="<?= $codigo ?>">
        <div class="campo">
          <div class="rotulo">
            <label>Senha atual</label>
          </div>
          <div class="controle">
            <input type="password" id="senha_atual" required>
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Nova senha</label>
          </div>
          <div class="controle">
            <input type="password" id="senha" required>
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Repetir nova senha</label>
          </div>
          <div class="controle">
            <input type="password" id="senha2" required>
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
<script src="usuario.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>
