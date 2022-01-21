<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="pastor.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>
  <div>
    <a onclick="voltar()">Pastores</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> 
  </div>
  <div id="info">
    <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank" title="Visualizar Manual."></a>
  </div>
</h1>
<div class="container">
  <div>
    <div class="card">
      <div class="campos">
        <input type="hidden" id="tabela" value="pastores">
        <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>"> 
        <div class="campo">
          <div class="rotulo">
            <label>Nome</label>
          </div>
          <div class="controle">
            <input type="text" 
                   class="texto" 
                   id="nome" 
                   required
                   maxlength="70"
                   value="<?= e($retorno->getNome()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Tratamento</label>
          </div>
          <div class="controle">
            <input type="text" 
                   class="texto" 
                   id="tratamento" 
                   maxlength="15"
                   value="<?= e($retorno->getTratamento()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Ata Entrada</label>
          </div>
          <div class="controle">
            <input type="text" 
                   class="inteiro" 
                   id="ata_entrada" 
                   maxlength="11"
                   value="<?= e($retorno->getAtaEntrada()) ?>"
                   onblur="verifica_ata(this);">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Data Entrada</label>
          </div>
          <div class="controle">
            <input type="text" 
                   class="data" 
                   id="dt_entrada" 
                   maxlength="10"
                   value="<?= e($retorno->getDtEntrada()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Ata Saída</label>
          </div>
          <div class="controle">
            <input type="text" 
                   class="inteiro" 
                   id="ata_saida" 
                   maxlength="11"
                   value="<?= e($retorno->getAtaSaida()) ?>"
                   onblur="verifica_ata(this);">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Data Saída</label>
          </div>
          <div class="controle">
            <input type="text" 
                   class="data" 
                   id="dt_saida" 
                   maxlength="10"
                   value="<?= e($retorno->getDtSaida()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Função na Igreja</label>
          </div>
          <div class="controle">
            <select id="funcao" onchange="valida_titular(this);">
              <?php foreach ($funcoes as $k => $v) : ?>
                <option value="<?= e($k) ?>" <?= ($k == $retorno->getCategoria()) ? 'selected' : '' ?> ><?= hs($v) ?></option>
              <?php endforeach; ?>
            </select>
            <div class="mensagem"></div>
          </div>
        </div>

        <input type="hidden" id="user_id" value="<?= e(\bd\Formatos::inteiro($retorno->getUserId())) ?>"> 
        <input type="hidden" id="created" value="<?= e(\bd\Formatos::dataHoraApp($retorno->getCreated())) ?>"> 
        <input type="hidden" id="modified" value="<?= e(\bd\Formatos::dataHoraApp($retorno->getModified())) ?>"> 
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
<script src="pastor.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>