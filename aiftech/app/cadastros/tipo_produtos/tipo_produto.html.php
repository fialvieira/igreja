<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
    <link rel="stylesheet" href="tipo_produto.css">
<?php $template->fimCss() ?>
<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Tipo Produtos</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="tabela" value="tipo_bens">
                    <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Nome</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="nome"

                                   required
                                   maxlength="80"
                                   value="<?= e($retorno->getNome()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Descrição</label>
                        </div>
                        <div class="controle">
                        <textarea class="memo"
                                  id="descricao"

                                  maxlength="65535"><?= e($retorno->getDescricao()) ?></textarea>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <!--<input type="hidden" id="empresa_id"
                           value="<?/*= e(\bd\Formatos::inteiro($retorno->getEmpresaId())) */?>">
                    <input type="hidden" id="user_id" value="<?/*= e(\bd\Formatos::inteiro($retorno->getUserId())) */?>">
                    <input type="hidden" id="created"
                           value="<?/*= e(\bd\Formatos::dataHoraApp($retorno->getCreated())) */?>">
                    <input type="hidden" id="modified"
                           value="<?/*= e(\bd\Formatos::dataHoraApp($retorno->getModified())) */?>">-->
                </div>
                <div class="botoes">
                    <?php if (Aut::temPermissao(Aut::$modulos['TIPO_PRODUTOS'], \modelo\Permissao::WRITE)): ?>
                        <a class="botao" onclick="salva()">Salvar</a>
                    <?php endif; ?>
                    <a class="botao" onclick="voltar()">Voltar</a>
                </div>
            </div>
        </div>
    </div>

<?php $template->fimMain() ?>
<?php $template->iniJs() ?>
    <script src="tipo_produto.js"></script>
<?php $template->fimJs() ?>
<?php $template->renderiza() ?>