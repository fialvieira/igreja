<div id="card_cadastro_usuario" class="card">
    <div class="campos">
        <div class="campo">
            <div class="rotulo">
                <label>Nome</label>
            </div>
            <div class="controle">
                <input type="text" id="nome" required>
                <div class="mensagem"></div>
            </div>
        </div>
        <div class="campo">
            <div class="rotulo">
                <label>CPF</label>
            </div>
            <div class="controle">
                <input type="text" id="cpf" class="cpf" onblur="validaUsuario(this)">
                <div class="mensagem"></div>
            </div>
        </div>
        <div class="campo">
            <div class="rotulo">
                <label>E-mail</label>
            </div>
            <div class="controle">
                <input type="email" id="email">
                <div class="mensagem"></div>
            </div>
        </div>
        <div class="campo">
            <div class="rotulo">
                <label>Celular</label>
            </div>
            <div class="controle">
                <input type="tel" id="fone_movel">
                <div class="mensagem"></div>
            </div>
        </div>
        <div class="campo">
            <div class="rotulo">
                <label>Login</label>
            </div>
            <div class="controle">
                <input type="text" id="login" required>
                <div class="mensagem"></div>
            </div>
        </div>
        <div class="campo">
            <div class="rotulo">
                <label>Senha</label>
            </div>
            <div class="controle">
                <input type="password" id="cadastro_senha" required>
                <div class="mensagem"></div>
            </div>
        </div>
        <div class="campo">
            <div class="rotulo">
                <label>Repetir senha</label>
            </div>
            <div class="controle">
                <input type="password" id="cadastro_senha2" required>
                <div class="mensagem"></div>
            </div>
        </div> 
    </div>
</div>