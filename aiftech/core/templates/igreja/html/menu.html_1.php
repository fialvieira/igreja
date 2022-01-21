<menu>
    <?php if (Aut::logado()): ?>
        <?php if (Aut::temPerfil(Aut::PERFIL_MASTER)): ?>
            <?php
            $menu_sup = modelo\Permissao::selecionaMenus();
            $menu_inf = \modelo\Permissao::seleciontaTodosModulos();
            $k = 0;
            /*d($menu_sup);
            d($menu_inf);*/
            ?>
            <?php for ($i = 0; $i < count($menu_sup); $i++): ?>
                <a><?= $menu_sup[$i]['descricao'] ?></a>
                <div class="submenu">
                <?php for ($j = $k; $j <= count($menu_inf); $j++): ?>
                    <?php if ($j == count($menu_inf)): ?>
                        </div>
                        <?php
                        $k = $j - 1;
                        break;
                        ?>
                    <?php endif; ?>
                    <?php if ($menu_sup[$i]['id'] != $menu_inf[$j]['menu_id']): ?>
                        </div>
                        <?php
                        $k = $j;
                        /*d($k);*/
                        break;
                        ?>
                    <?php else: ?>
                        <a href="<?= SITE . $menu_inf[$j]['path'] ?>"
                           target="<?= $menu_inf[$j]['target'] ?>"><?= $menu_inf[$j]['descricao'] ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endfor; ?>
        <?php else: ?>
            <?php
            $permissoes = Aut::$usuario->getPermissoes();
            $menu_ant = null;
            ?>
            <?php foreach ($permissoes as $permissao) : ?>
                <?php if ($menu_ant != $permissao['menu_id']): ?>
                    <?php if (!is_null($menu_ant)) : ?>
                        </div>
                    <?php endif; ?>
                    <a><?= $permissao['menu'] ?></a>
                    <div class="submenu">
                    <?php $menu_ant = $permissao['menu_id']; ?>
                <?php endif; ?>
                <a href="<?= SITE . $permissao['path'] ?>"
                   target="<?= $permissao['target'] ?>"><?= $permissao['desc_modulo'] ?></a>
            <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (Aut::temPerfil(Aut::PRESIDENTE, Aut::PERFIL_ADMIN, Aut::PERFIL_MASTER)): ?>
        <a>Central Autenticação</a>
        <div class="submenu">
            <a href="<?= SITE ?>app/cadastros/permissoes/index.php">Permissões</a>
            <a href="<?= SITE ?>app/cadastros/usuarios/index.php">Usuários</a>
        </div>
    <?php endif; ?>
</menu>