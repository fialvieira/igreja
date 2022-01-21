<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="parametros.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>
    <div>
        Parametros 
    </div>
</h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="id" value="<?= e($retorno->getId()) ?>"> 
                <div class="campo">
                    <div class="rotulo">
                        <label>Idade Quorúm</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               maxlength="3"
                               id="idade_quorum" 
                               value="<?= e($retorno->getIdadeQuorum()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Id Presidentes</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="" 
                               id="id_presidentes_ata" 
                               maxlength="50"
                               value="<?= e($retorno->getIdPresidentesAta()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Id Secretários</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="" 
                               id="id_secretarios_ata" 
                               maxlength="50"
                               value="<?= e($retorno->getIdSecretariosAta()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>E-mail Administrativo</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="email" 
                               id="email_administrativo" 
                               maxlength="200"
                               value="<?= e($retorno->getEmailAdministrativo()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="botoes">
                    <a class="botao" id="salvar" onclick="salva()">Salvar</a>
                </div>
            </div>
        </div>
    </div>

    <?php $template->fimMain() ?>

    <?php $template->iniJs() ?>
    <script src="parametros.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>