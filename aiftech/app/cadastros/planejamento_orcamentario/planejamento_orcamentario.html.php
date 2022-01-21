<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="planejamento_orcamentario.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
<h1><a onclick="voltar()">Planejamento Orçamentário</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="codigo" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                <div class="campo">
                    <div class="rotulo">
                        <label>Ano</label>
                    </div>
                    <div class="controle">
                        <?php if (!$retorno->getAno()): ?>
                            <select id="ano" required>
                                <?php foreach ($anos as $ano): ?>
                                    <option value="<?= e($ano['ano']) ?>" <?= ($ano['ano'] == $year)? 'selected' : '' ?>><?= e($ano['ano']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <input type="text" id="txt_ano" disabled value="<?= e($retorno->getAno()) ?>">
                        <?php endif; ?>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Mês</label>
                    </div>
                    <div class="controle">
                        <?php if (!$retorno->getMes()): ?>
                            <select id="mes" required>
                                <option value=""></option>
                                <?php foreach ($meses as $k => $v): ?>
                                    <option value="<?= e(str_pad($k, 2, '0', STR_PAD_LEFT)) ?>"><?= e($v) ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php else: ?>
                            <input type="text" id="txt_mes" disabled value="<?= e(mesPorExtenso($retorno->getMes())) ?>">
                        <?php endif; ?>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Conta</label>
                    </div>
                    <div class="controle">
                        <?php if (!$retorno->getCategoriaId()): ?>
                            <select id="conta" required>
                                <option value=""></option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= hs($categoria['id']) ?>"><?= hs($categoria['num'] . ' - ' . $categoria['nome']) ?></option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <input type="text" id="txt_conta" disabled value="<?= e($retorno->getCategoriaNome()) ?>">
                            <?php endif; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Valor Previsto</label>
                    </div>
                    <div class="controle">
                        <input type="text"
                               class="real"
                               id="valor_previsto"
                               required
                               value="<?= e($retorno->getValorPrevisto()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
            </div>
            <div class="botoes">
                <a class="botao" onclick="confirmar()">Salvar</a>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
</div>

<div id="j_confirma" class="modal">
    <header>
        <h2>Replicar alteração de valor.</h2>
        <a class="fechar" title="Fechar janela"></a>
    </header>
    <section>
        Deseja replicar o novo valor para todos os meses futuros deste planejamento?
    </section>
    <div class="botoes">
        <a class="botao" onclick="confirma('S')">Sim</a>
        <a class="botao" onclick="confirma('N')">Não</a>
    </div>
</div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script src="planejamento_orcamentario.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>