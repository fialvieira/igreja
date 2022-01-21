<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="empresa.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1><a onclick="voltar()">Igrejas</a> / <?= (!$retorno->getId()) ? "Novo" : "Alterar" ?> </h1>
<div class="container">
  <div>
    <div class="card">
      <div class="campos">
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
                   maxlength="150"
                   value="<?= e($retorno->getNome()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Abreviação</label>
          </div>
          <div class="controle">
            <input type="text" 
                   class="texto" 
                   id="abreviacao" 
                   required
                   maxlength="100"
                   value="<?= e($retorno->getAbreviacao()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Cnpj</label>
          </div>
          <div class="controle">
            <input type="text" 
                   class="cnpj" 
                   id="cnpj" 
                   required
                   value="<?= e($retorno->getCnpj()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Telefone</label>
          </div>
          <div class="controle">
            <input type="tel" 
                   class="telefone" 
                   id="telefone" 
                   required
                   maxlength="15"
                   value="<?= e($retorno->getTelefone()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Celular</label>
          </div>
          <div class="controle">
            <input type="tel" 
                   class="telefone" 
                   id="celular" 
                   maxlength="15"
                   value="<?= e($retorno->getCelular()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Cep</label>
          </div>
          <div class="controle">
            <input type="text"
                   class="cep"
                   id="cep"
                   maxlength="9"
                   onblur="consultaCep(this)"
                   data-id="<?= e(($end_flag) ? $end->getId() : '') ?>"
                   value="<?= e(($end_flag) ? $end->getCep() : '') ?>"
                   >
            <div id="msg"></div>
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Logradouro</label>
          </div>
          <div class="controle">
            <input type="text" id="logradouro"
                   value="<?= e(($end_flag) ? $end->getLogradouro() : '') ?>" 
                   data-value="<?= e(($end_flag) ? $end->getLogradouro() : '') ?>"
                   onfocus="validaEndereco()">
            <!--onblur="checaAjuste(this)" disabled>-->
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Número</label>
          </div>
          <div class="controle">
            <input type="text" id="numero" value="<?= e($retorno->getNumero()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Complemento</label>
          </div>
          <div class="controle">
            <input type="text" id="complemento" value="<?= e($retorno->getComplemento()) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Bairro</label>
          </div>
          <div class="controle">
            <input type="text" id="bairro" value="<?= e(($end_flag) ? $end->getBairro() : '') ?>" onblur="checaAjuste(this)">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Cidade</label>
          </div>
          <div class="controle">
            <input type="text" id="localidade"
                   value="<?= e(($end_flag) ? $end->getLocalidade() : '') ?>" onblur="checaAjuste(this)" disabled>
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Estado</label>
          </div>
          <div class="controle">
            <select id="uf" onblur="checaAjuste(this)" disabled>
              <option value=""></option>
              <?php
              foreach ($estados as $k => $v):
                if ($end_flag) {
                  if ($v['id'] == $end->getEstado()) {
                    $selecionado = 'selected';
                  } else {
                    $selecionado = '';
                  }
                } else {
                  $selecionado = '';
                }
                ?>
                <option value="<?= $v['id'] ?>" <?= $selecionado ?>><?= e($v['sigla']) ?></option>
              <?php endforeach; ?>
            </select>
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Email</label>
          </div>
          <div class="controle">
            <input type="email" 
                   class="email" 
                   id="email" 
                   maxlength="150"
                   value="<?= e(\bd\Formatos::email($retorno->getEmail())) ?>">
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Pastor Titular</label>
          </div>
          <div class="controle">
            <select id="pastor">
              <option value=""></option>
              <?php foreach ($pastores as $pastor) : ?>
                <option <?= ($pastor['id'] == $retorno->getPastorId()) ? 'selected' : '' ?>
                  value="<?= hs($pastor['id']) ?>"><?= e($pastor['nome']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mensagem"></div>
          </div>
        </div>
        <div class="campo">
          <div class="rotulo">
            <label>Associação</label>
          </div>
          <div class="controle">
            <select id="associacao">
              <option value=""></option>
              <?php foreach ($associacoes as $associacao) : ?>
                <option <?= ($associacao['id'] == $retorno->getAssociacaoId()) ? 'selected' : '' ?>
                  value="<?= hs($associacao['id']) ?>"><?= e($associacao['sigla']) ?></option>
                <?php endforeach; ?>
            </select>
            <div class="mensagem"></div>
          </div>
        </div>
      </div>
      <div class="botoes">
        <?php if ($permitido): ?>
          <a class="botao" onclick="salva()">Salvar</a>
        <?php endif; ?>
        <a class="botao" onclick="voltar()">Voltar</a>
      </div>
    </div>
  </div>
</div>

<div id="j_enderecos" class="combo flutuante">
  <div id="detalhes_grid">
    <table>
      <tbody>
      </tbody>
    </table>
  </div>
</div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script src="empresa.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>