<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="cargo.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Cargos</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="tabela" value="cargos">
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
                                   maxlength="45"
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
                            <label>Abreviação</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="abreviacao"
                                   maxlength="30"
                                   value="<?= e($retorno->getAbreviacao()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Tipo</label>
                        </div>
                        <div class="controle">
                            <select id="tipo_comissao">
                                <option value=""></option>
                                <option value="E" <?= ("E" == strtoupper(e($retorno->getTipoComissao()))) ? "selected" : "" ?>><?= ucwords("Estatutária") ?></option>
                                <option value="E" <?= ("D" == strtoupper(e($retorno->getTipoComissao()))) ? "selected" : "" ?>><?= ucwords("Diretoria") ?></option>
                                <option value="E" <?= ("M" == strtoupper(e($retorno->getTipoComissao()))) ? "selected" : "" ?>><?= ucwords("Ministérios") ?></option>
                                <option value="E" <?= ("P" == strtoupper(e($retorno->getTipoComissao()))) ? "selected" : "" ?>><?= ucwords("Projetos") ?></option>
                                <option value="E" <?= ("C" == strtoupper(e($retorno->getTipoComissao()))) ? "selected" : "" ?>><?= ucwords("Comissão") ?></option>
                                <option value="O" <?= ("O" == strtoupper(e($retorno->getTipoComissao()))) ? "selected" : "" ?>><?= ucwords("Outras") ?>
                                </option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>

                    <div class="campo">
                        <div class="rotulo">
                            <label>Departamento</label>
                        </div>
                        <div class="controle">
                            <select id="departamento" onchange="adicionaDepartamento(this)">
                                <option value=""></option>
                                <?php foreach ($departamentos as $k => $v): ?>
                                    <option value="<?= e($v['id']) ?>"><?= e($v['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="ctn_departamentos">
                                <?php if (!is_null($id)): ?>
                                    <?php foreach ($cargo_dep as $k => $v): ?>
                                        <div class="a_cargo_dep">
                                            <a data-id="<?= e($v['departamento_id']) ?>" class="acao excluir"
                                               onclick="remover(this)"></a>
                                            <label><?= e($v['departamento']) ?></label>&nbsp;
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="mensagem"></div>
                        </div>
                    </div>
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
    <script src="cargo.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>