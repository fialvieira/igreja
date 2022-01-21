<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="permissoes.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Permissões para Usuários</a> / <?= (!$usuario_id) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Usuário</label>
                        </div>
                        <div class="controle">
                            <select id="user" <?= ($usuario_id != '') ? 'disabled' : '' ?> required>
                                <option value=""></option>
                                <?php foreach ($usuarios as $usuario) : ?>
                                    <?php if($usuario['perfil'] != Aut::PERFIL_MASTER): ?>
                                        <option value="<?= $usuario['id'] ?>" <?= e(($usuario['id'] == $usuario_id) ? 'selected' : '') ?>><?= $usuario['nome'] ?></option>
                                        <?php else: ?>
                                            <?php if(Aut::temPerfil(Aut::PERFIL_MASTER)): ?>
                                            <option value="<?= $usuario['id'] ?>" <?= e(($usuario['id'] == $usuario_id) ? 'selected' : '') ?>><?= $usuario['nome'] ?></option>
                                            <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <?php foreach ($retorno as $ret) : ?>
                        <?php if ($menu_ant != $ret['menu_id']): ?>
                            <div class="campo">
                                <div class="rotulo">
                                    <label class="menu">Menu <?= $ret['menu'] ?></label>
                                </div>
                                <div class="controle"></div>
                            </div>
                            <?php $menu_ant = $ret['menu_id']; ?>
                        <?php endif; ?>
                        <div class="campo">
                            <div class="rotulo submenu">
                                <label>Módulo <?= $ret['desc_modulo'] ?></label>
                            </div>
                            <div class="controle submenu">
                                <select class="permissao"
                                        id="permissao_<?= $ret['id_modulo'] ?>"
                                        data-id="<?= $ret['id'] ?>"
                                        data-modulo_id="<?= $ret['id_modulo'] ?>">
                                    <option value=""></option>
                                    <?php foreach ($permissoes as $k => $v) : ?>
                                        <option value="<?= $k ?>" <?= e(($k == $ret['permissao']) ? 'selected' : '') ?>><?= $v ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="mensagem"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
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
    <script src="permissoes.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>