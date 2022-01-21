<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="local.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Locais</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="codigo" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Nome Localidade</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="nome"
                                   maxlength="40"
                                   required
                                   value="<?= e($retorno->getNome()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Localizado na Sede</label>
                        </div>
                        <div class="controle">
                            <select id="sede">
                                <option value=""></option>
                                <option value="S" <?= e(($retorno->getSede() === 'S') ? 'selected' : '') ?>>Sim</option>
                                <option value="N" <?= e(($retorno->getSede() === 'N') ? 'selected' : '') ?>>Não</option>
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

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="local.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>