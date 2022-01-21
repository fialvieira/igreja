<menu>
    <?php if (Aut::logado()): ?>
        <?php if (Aut::temPerfil(Aut::PERFIL_MASTER, Aut::PERFIL_ADMIN, Aut::ADMINISTRATIVO, Aut::PRESIDENTE)): ?>
            <a>Cadastros</a>
            <div class="submenu">
                <?php if (Aut::temPerfil(1, 2, 3, 5)): ?>
                    <a href="<?= SITE ?>app/cadastros/membros/index.php">Membros</a>
                    <!--<a href="<?/*= SITE */?>app/cadastros/atas/index.php">Atas</a>-->
                    <a href="<?= SITE ?>app/cadastros/dons/index.php">Dons</a>
                    <a href="<?= SITE ?>app/cadastros/cargos/index.php">Cargos</a>
                    <!--<a href="<?= SITE ?>app/cadastros/contatos/index.php">Contatos</a>-->
                    <a href="<?= SITE ?>app/cadastros/departamentos/index.php">Departamentos</a>
                    <a href="<?= SITE ?>app/cadastros/local/index.php">Locais</a>
                    <!--                    <a href="<?= SITE ?>app/cadastros/escolaridades/index.php">Escolaridades</a>-->
                    <a href="<?= SITE ?>app/cadastros/profissoes/index.php">Profissões</a>
                    <!--                    <a href="<?= SITE ?>app/cadastros/relacionamentos/index.php">Relacionamentos</a>
                    <a href="<?= SITE ?>app/cadastros/tiporelacionamentos/index.php">Tipos de Relacionamento</a>-->
                    <!--<a href="<?= SITE ?>app/cadastros/categorias/index.php">Categorias</a>-->
                    <!--                    <a href="<?= SITE ?>app/cadastros/atas/index.php">Atas</a>
                    <a href="<?= SITE ?>app/cadastros/autores/index.php">Autores</a>
                    <a href="<?= SITE ?>app/cadastros/editoras/index.php">Editoras</a>
                    <a href="<?= SITE ?>app/cadastros/bens/index.php">Bens</a>
                    <a href="<?= SITE ?>app/cadastros/tipo_bens/index.php">Tipos de Bem</a>
                    <a href="<?= SITE ?>app/cadastros/movimentacao_bens/index.php">Movimentação de Bens</a>
                    <a href="<?= SITE ?>app/cadastros/itens/index.php">Itens</a>
                    <a href="<?= SITE ?>app/cadastros/tipo_biblioteca/index.php">Tipo Biblioteca</a>
                    <a href="<?= SITE ?>app/cadastros/movimentacao_itens/index.php">Movimentação de Itens</a>
                    <a href="<?= SITE ?>app/cadastros/calendarios/index.php">Calendários</a>-->
                    <!--                    <a href="<?= SITE ?>app/cadastros/enderecos/index.php">Endereços</a>
                    <a href="<?= SITE ?>app/cadastros/estados/index.php">Estados</a>-->
                    <a href="<?= SITE ?>app/cadastros/fornecedores/index.php">Fornecedores</a>
                    <a href="<?= SITE ?>app/cadastros/tipo_fornecedores/index.php">Tipo Fornecedores</a>
                    <a href="<?= SITE ?>app/cadastros/pastores/index.php">Pastores</a>
                    <!--<a href="<?= SITE ?>app/cadastros/representante/index.php">Representantes</a>-->
                <?php endif; ?>
            </div>
            <a>Relatórios</a>
            <div class="submenu">
                <?php if (Aut::temPerfil(1, 2, 3, 5)): ?>
                    <a href="<?= SITE ?>app/relatorios/membros_aniversariantes/index.php">Membros Aniversariantes</a>
                    <a href="<?= SITE ?>app/relatorios/membros_matrimonios/index.php">Membros Aniversário de
                        Casamento</a>
                    <a href="<?= SITE ?>app/relatorios/membros_inconsistencias/index.php" target="_blank">Membros Inconsistências</a>
                    <a href="<?= SITE ?>app/relatorios/membros_menores/index.php">Membros Menores de 18 Anos</a>
                    <a href="<?= SITE ?>app/relatorios/membros_quorum/index.php" target="_blank">Membros Quórum</a>
                <?php endif; ?>
            </div>
            <?php if (Aut::temPerfil(Aut::PERFIL_MASTER)): ?>
            <a>Central Autenticação</a>
            <div class="submenu">
                <a href="<?= SITE ?>app/cadastros/permissoes/index.php">Permissões</a>
                <a href="<?= SITE ?>app/cadastros/usuarios/index.php">Usuários</a>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
</menu>