<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

    <div class="container">
        <div>
            <div class="card" id="card_valida_usuario">
                <div class="campos">
                    <div class="campo">
                        <div class="rotulo"><label>Login</label></div>
                        <div class="controle">
                            <input type="text" id="index_login" required>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo"><label>Senha</label></div>
                        <div class="controle">
                            <input type="password" id="index_senha" onkeypress="enter(event,this)" required>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                </div>
                <div class="botoes">
                    <div class="botao" onclick="entra()">Entrar</div>
                    <div class="botao" onclick="cadastra()">Novo login</div>
                    <div class="botao" onclick="abreModal('j_reset_senha')">Lembrar senha</div>
                </div>
            </div>
        </div>
    </div>

    <div id="j_cadastro_usuario" class="modal">
        <header>
            <h2>Cadastro Usuário</h2>
            <a class="fechar" title="Fechar janela"></a>
        </header>
        <section>
            <?php include 'usuario.html.php'; ?>
        </section>
        <div class="botoes">
            <a class="botao" id="btn_salvar" onclick="salva()">Salvar</a>
            <a class="botao" onclick="modal.fecha()">Voltar</a>
        </div>
    </div>

    <div id="j_reset_senha" class="modal">
        <header>
            <h2>Redefinir Senha</h2>
            <a class="fechar" title="Fechar janela"></a>
        </header>
        <section>
            <?php include 'reset_senha.html.php'; ?>
        </section>
        <div class="botoes">
            <a class="botao" id="btn_salvar" onclick="enviar()">Enviar</a>
            <a class="botao" onclick="modal.fecha()">Voltar</a>
        </div>
    </div>

    <div id="j_nova_senha" class="modal">
        <header>
            <h2>Cadastrar nova senha</h2>
            <a class="fechar" title="Fechar janela"></a>
        </header>
        <section>
            <?php include 'nova.html.php'; ?>
        </section>
        <div class="botoes">
            <a class="botao oculto" id="btn_salvar_nova" onclick="salva_senha()">Salvar</a>
            <a class="botao" onclick="modal.fecha()">Voltar</a>
        </div>
    </div>
    
<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="index.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>