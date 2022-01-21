<?php $template = new \templates\Igreja()?>

<?php $template->iniCss()?>
<link rel="stylesheet" href="index.css">
<?php $template->fimCss()?>

<?php $template->iniMain()?>

<div class="container-grid">
    <h1>Usuários</h1>
    <div class="qbe">
        <div class="campos campos-horizontais">
            <div class="campo">
                <div class="controle">
                    <input type="text" id="pesquisa_ftxt" placeholder="Nome/CPF/e-mail" onkeypress="enter(event)">
                    <div class="mensagem"></div>
                </div>
            </div>
            <?php if(Aut::temPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::PRESIDENTE, Aut::ADMINISTRATIVO)):?>
              <div class="campo">
                  <div class="controle">
                      <select id="sel_status" onchange="pesquisa('ft')">
                        <option value="" selected>Status</option>
                        <option value="S">Ativo</option>
                        <option value="N">Desativado</option>
                      </select>
                      <div class="mensagem"></div>
                  </div>
              </div>
            <?php endif;?>
            <a class="botao" onclick="pesquisa('ft')">Pesquisar</a>
            <?php if(Aut::temPerfil(Aut::PERFIL_MASTER, Aut::PRESIDENTE, Aut::ADMINISTRATIVO)):?>
              <a class="botao" href="usuario.php">Novo</a>
            <?php endif;?>
        </div>
    </div>
    <div id="ctn_totalizador">
        <span id="total_registros"></span>
    </div>
    <div class="grid"></div>
</div>

<?php $template->fimMain()?>

<?php $template->iniJs()?>
<script src="index.js"></script>
<?php $template->fimJs()?>

<?php $template->renderiza()?>
