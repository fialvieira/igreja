<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="centro_custo.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
<h1><a onclick="voltar()">Centro de Custo</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="codigo" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                <div class="campo">
                    <div class="rotulo">
                        <label>Descrição</label>
                    </div>
                    <div class="controle">
                        <input type="text"
                               class="texto"
                               id="descricao"
                               maxlength="100"
                               required
                               value="<?= e($retorno->getDescricao()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Principal</label>
                    </div>
                    <div class="controle">
                        <select id="principal" onchange="mudaPrincipal();">
                            <?php foreach ($array as $k => $v): ?>
                                <option value="<?= $k ?>" <?= ($k == $retorno->getPrincipal())? 'selected' : '' ?>><?= $v ?></option>
                            <?php endforeach; ?>
                        </select>
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

<div id="j_principal" class="modal" data-principal="<?= hs($principal['descricao']) ?>">
    <header>
        <h2>Alterar Centro de Custo Principal</h2>
        <a class="fechar" title="Fechar janela"></a>
    </header>
    <section>
        Deseja alterar o Centro de Custo principal? Atualmente o Centro de Custo principal é o <?= $principal['descricao'] ?>, o mesmo deixará de ser.
    </section>
    <div class="botoes">
        <a class="botao" onclick="confirmaPrincipal()">Confirmar</a>
        <a class="botao" onclick="modal.fecha()">Voltar</a>
    </div>
</div>


<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script src="centro_custo.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>