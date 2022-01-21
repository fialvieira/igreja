<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="item.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

    <!--<h1><a href="ndex.php">Itens</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>-->
    <h1><a onclick="voltar()">Itens</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="tabela" value="itens">
                    <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Isbn</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="isbn"
                                   maxlength="50"
                                   value="<?= e($retorno->getIsbn()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Titulo</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="titulo"

                                   required
                                   maxlength="150"
                                   value="<?= e($retorno->getTitulo()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Foto</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="foto"


                                   maxlength="150"
                                   value="<?= e($retorno->getFoto()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Paginas</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="inteiro"
                                   id="paginas"


                                   maxlength="11"
                                   value="<?= e(\bd\Formatos::inteiro($retorno->getPaginas())) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Preco</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="real"
                                   id="preco"
                                   data-casas="2"

                                   maxlength="21"
                                   value="<?= e(\bd\Formatos::real($retorno->getPreco())) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Comentarios</label>
                        </div>
                        <div class="controle">
                        <textarea class="memo"
                                  id="comentarios"

                                  maxlength="65535"><?= e($retorno->getComentarios()) ?></textarea>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Estoque</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="inteiro"
                                   id="estoque"


                                   maxlength="11"
                                   value="<?= e(\bd\Formatos::inteiro($retorno->getEstoque())) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Autor</label>
                        </div>
                        <div class="controle">
                            <select id="autor_id"
                                    data-tabela="autores"
                                    data-codigo="id"
                                    data-descricao="nome"
                            >
                                <option value=""></option>
                                <?php foreach ($autores as $tbl): ?>
                                    <option value="<?= e($tbl["id"]) ?>"
                                        <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getAutorId()))) ? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Categoria</label>
                        </div>
                        <div class="controle">
                            <select id="categoria_id"
                                    data-tabela="categorias"
                                    data-codigo="id"
                                    data-descricao="nome"
                            >
                                <option value=""></option>
                                <?php foreach ($categorias as $tbl): ?>
                                    <option value="<?= e($tbl["id"]) ?>"
                                        <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getCategoriaId()))) ? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Editora</label>
                        </div>
                        <div class="controle">
                            <select id="editora_id"
                                    data-tabela="editoras"
                                    data-codigo="id"
                                    data-descricao="nome"
                            >
                                <option value=""></option>
                                <?php foreach ($editoras as $tbl): ?>
                                    <option value="<?= e($tbl["id"]) ?>"
                                        <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getEditoraId()))) ? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Tipo</label>
                        </div>
                        <div class="controle">
                            <select id="tipo_id"
                                    data-tabela="tipo_biblioteca"
                                    data-codigo="id"
                                    data-descricao="nome"
                            >
                                <option value=""></option>
                                <?php foreach ($tipo_biblioteca as $tbl): ?>
                                    <option value="<?= e($tbl["id"]) ?>"
                                        <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getTipoId()))) ? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <input type="hidden" id="empresa_id"
                           value="<?= e(\bd\Formatos::inteiro($retorno->getEmpresaId())) ?>">
                    <input type="hidden" id="user_id" value="<?= e(\bd\Formatos::inteiro($retorno->getUserId())) ?>">
                    <input type="hidden" id="created"
                           value="<?= e(\bd\Formatos::dataHoraApp($retorno->getCreated())) ?>">
                    <input type="hidden" id="modified"
                           value="<?= e(\bd\Formatos::dataHoraApp($retorno->getModified())) ?>">
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
    <script src="item.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>