<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
    <link rel="stylesheet" href="produto.css">
<?php $template->fimCss() ?>
<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Produtos</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="tabela" value="bens">
                    <input type="hidden" id="id" value="<?= e($retorno->getId()) ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Nome</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="nome"
                                   required
                                   maxlength="400"
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
                    <div class="campo">
                        <div class="rotulo">
                            <label>Unidade Medida</label>
                        </div>
                        <div class="controle">
                            <select id="unidade_medida">
                                <option value=""></option>
                                <?php foreach (\modelo\Produto::UNIDADES_MEDIDAS as $k => $v): ?>
                                    <option value="<?= e($k) ?>" <?= ($retorno->getUnidadeMedida() == $k) ? 'selected' : '' ?>><?= e($v) ?></option>
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
                            <select id="categoria" required>
                                <option value=""></option>
                                <option value="P" <?= ($retorno->getCategoria() == 'P') ? 'selected' : '' ?>>Produto
                                </option>
                                <option value="S" <?= ($retorno->getCategoria() == 'S') ? 'selected' : '' ?>>Serviço
                                </option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Tipo Produto</label>
                        </div>
                        <div class="controle">
                            <select id="tipo_produto">
                                <option value=""></option>
                                <?php foreach ($tipo_produtos as $k => $v): ?>
                                    <option value="<?= $v['id'] ?>" <?= ($v['id'] == $retorno->getTipoProdutoId()) ? 'selected' : '' ?>><?= e($v['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Fornecedor</label>
                        </div>
                        <div class="controle">
                            <select id="fornecedor" onchange="adicionaLinha(this, 'ctn_fornecedor')">
                                <option value=""></option>
                                <?php foreach ($fornecedores as $k => $v): ?>
                                    <option value="<?= $v['id'] ?>"><?= e($v['nome_fantasia']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="ctn_fornecedor">
                                <?php if (!is_null($id)): ?>
                                    <?php foreach ($fornecedores_produto as $k => $v): ?>
                                        <div class="a_fornecedor">
                                            <a data-id="<?= e($v['id']) ?>" class="acao excluir"
                                               onclick="remover(this)"></a>
                                            <label><?= e($v['nome_fantasia']) ?></label>&nbsp;
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="mensagem"></div>
                        </div>
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
    <script src="produto.js"></script>
<?php $template->fimJs() ?>
<?php $template->renderiza() ?>