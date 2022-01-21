<?php /* @var $usuario \modelo\Usuario */?>

<?php $template = new \templates\Igreja()?>

<?php $template->iniCss()?>
<link rel="stylesheet" href="usuario.css">
<?php $template->fimCss()?>

<?php $template->iniMain()?>

<h1><a href="index.php">Usuários</a> / <?=(!$codigo) ? 'Novo' : 'Alterar'?></h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="codigo" value="<?=$codigo?>">
                <div class="campo">
                    <div class="rotulo">
                        <label>Nome</label>
                    </div>
                    <div class="controle">
                        <input type="text" id="nome" required value="<?=e($usuario->getNome())?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>CPF</label>
                    </div>
                    <div class="controle">
                        <input type="text" class="cpf" id="cpf" <?=($usuario->getCpf()) ? 'disabled' : ''?> value="<?=e($usuario->getCpf())?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>E-mail</label>
                    </div>
                    <div class="controle">
                        <input type="email" id="email" value="<?=e($usuario->getEmail())?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Celular</label>
                    </div>
                    <div class="controle">
                        <input type="tel" id="fone_movel" value="<?=e($usuario->getCelular())?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Login</label>
                    </div>
                    <div class="controle">
                        <input type="text" id="login" value="<?=e($usuario->getUsuario())?>" required>
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
                <?php if(Aut::temPerfil(Aut::PERFIL_MASTER, Aut::PRESIDENTE, Aut::ADMINISTRATIVO)):?>
                  <div class="campo">
                      <div class="rotulo">
                          <label>Perfil</label>
                      </div>
                      <div class="controle">
                          <select id="perfil" required>
                              <option value=""></option>
                              <?php foreach($perfis as $k => $v):?>
                                <?php if($k == Aut::PERFIL_MASTER):?>
                                  <?php if(Aut::temPerfil(Aut::PERFIL_MASTER)):?>
                                    <option value="<?=$k?>" <?=$k == $usuario->getPerfil() ? 'selected' : ''?> ><?=$v?></option>
                                  <?php endif;?>
                                <?php else:?>
                                  <option value="<?=$k?>" <?=$k == $usuario->getPerfil() ? 'selected' : ''?> ><?=$v?></option>
                                <?php endif;?>
                              <?php endforeach;?>
                          </select>
                          <div class="mensagem"></div>
                      </div>
                  </div>
                <?php endif;?>
            </div>
            <div class="botoes">
                <a class="botao" onclick="salva()">Salvar</a>
                <a class="botao oculto" id="btn_troca_senha" onclick="troca_senha()">Trocar Senha</a>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
</div>


<?php $template->fimMain()?>

<?php $template->iniJs()?>
<script src="usuario.js"></script>
<?php $template->fimJs()?>

<?php $template->renderiza()?>
