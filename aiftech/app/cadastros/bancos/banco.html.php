<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="banco.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Bancos</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="tabela" value="bancos">
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
                                   maxlength="100"
                                   value="<?= e($retorno->getNome()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Número</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="numero"
                                   required
                                   maxlength="5"
                                   value="<?= e($retorno->getNumero()) ?>"
                                   onblur="validaNumero(this)">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>CNPJ</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="cnpj"
                                   id="cnpj"
                                   required
                                   maxlength="20"
                                   value="<?= e($retorno->getCnpj()) ?>"
                                   onblur="validaNumero(this)">
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
    <script src="banco.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>