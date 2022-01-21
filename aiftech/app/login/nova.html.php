<div id="card_nova_senha" class="card">
  <div class="campos">
    <div class="campo">
      <div class="rotulo">
        <label>CPF</label>
      </div>
      <div class="controle">
        <input type="text" id="cpf_senha" class="cpf" onblur="validaUsuario(this,'nova_senha')" onkeyup="enter(event, this)" required>
        <div class="mensagem"></div>
      </div>
    </div>
    <div class="campo oculto">
      <div class="rotulo">
        <label>Senha</label>
      </div>
      <div class="controle">
        <input type="password" id="nova_senha" required>
        <div class="mensagem"></div>
      </div>
    </div>
    <div class="campo oculto">
      <div class="rotulo">
        <label>Repetir senha</label>
      </div>
      <div class="controle">
        <input type="password" id="nova_senha2" required>
        <div class="mensagem"></div>
      </div>
    </div> 
  </div>
</div>