<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="categorias_financeira.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Plano Contas</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?></h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="tabela" value="categorias_financeira">
                    <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                    <input type="hidden" id="tipo_ins_upd" value="<?= e((!$filtro[0]) ? "N" : "A") ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Conta Principal</label>
                        </div>
                        <div class="controle">
                            <select id="categoria_mae" onchange="ajustaTipo(this)">
                                <option value=""></option>
                                <?php foreach ($categorias_mae as $k => $v):
                                    $cat_mae_total = \modelo\CategoriasFinanceira::verificaCategoriaMae($v['id']);
                                    $classe = '';
                                    if ($cat_mae_total > 0) {
                                        $classe = 'negrito';
                                    }
                                    ?>
                                    <option value="<?= e($v["id"]) ?>" class="<?= $classe ?>"
                                        <?= ($v["id"] == e($retorno->getCategoriaMae())) ? "selected" : "" ?>><?= e($v['num'] . ' - ' . $v['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Número</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   id="numero"
                                   required
                                   maxlength="20"
                                   onblur="ajustaNumero(this)"
                                   onkeyup="escreveMensagem(this)"
                                   value="<?= e($retorno->getNumero()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Nome</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="nome"

                                   required
                                   maxlength="100"
                                   value="<?= e($retorno->getNome()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Tipo</label>
                        </div>
                        <div class="controle">
                            <select id="tipo" required>
                                <option value=""></option>
                                <option value="R" <?= $retorno->getTipo() == 'R' ? 'selected' : '' ?>>Receita</option>
                                <option value="D" <?= $retorno->getTipo() == 'D' ? 'selected' : '' ?>>Despesa</option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Responsável</label>
                        </div>
                        <div class="controle">
                            <select id="responsavel">
                                <option value=""></option>
                                <option value="PA" <?= $retorno->getResponsavel() == 'PA' ? 'selected' : '' ?>>Pastor</option>
                                <option value="PR" <?= $retorno->getResponsavel() == 'PR' ? 'selected' : '' ?>>Presidente</option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Descricao</label>
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
                            <label>Conta Bancária</label>
                        </div>
                        <div class="controle">
                            <select id="conta_bancaria" onchange="adicionaLinha(this, 'ctn_conta_bancaria')">
                                <option value=""></option>
                                <?php foreach ($contas_financeiras as $k => $v): ?>
                                    <option value="<?= e($v['id']) ?>"><?= e(($v['tipo_conta'] != 'V') ? $v['nome'] . ' (' . $v['agencia'] . ' - ' . $v['numero'] . ') - ' . $v['banco_descricao'] : $v['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="ctn_conta_bancaria">
                                <?php if (!is_null($id)): ?>
                                    <?php foreach ($bancos as $k => $v): ?>
                                        <div class="a_conta_bancaria">
                                            <a data-id="<?= e($v['conta_id']) ?>"
                                               class="acao excluir"
                                               onclick="remover(this)"></a>
                                            <label><?= e(($v['tipo_conta'] != 'V') ? $v['conta_nome'] . ' (' . $v['agencia'] . ' - ' . $v['numero'] . ') - ' . $v['banco_nome'] : $v['conta_nome']) ?></label>&nbsp;
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
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
                    <a class="botao" onclick="volta()">Voltar</a>
                    <a class="botao" onclick="limpaCampos()">Limpar</a>
                </div>
            </div>
        </div>
    </div>
<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="categorias_financeira.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>