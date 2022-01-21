<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="representante.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<!--<h1><a href="ndex.php">Representante</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>-->
<h1><a onclick="voltar()">Representante</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="representante">
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
                               maxlength="150"
                               value="<?= e($retorno->getNome()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Email</label>
                    </div>
                    <div class="controle">
                        <input type="email" 
                               class="email" 
                               id="email" 
                               
                               required
                               maxlength="150"
                               value="<?= e(\bd\Formatos::email($retorno->getEmail())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Idade</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="idade" 
                               
                               required
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getIdade())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>DDD</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="ddd" 
                               
                               required
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getDdd())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Telefone</label>
                    </div>
                    <div class="controle">
                        <input type="tel" 
                               class="telefone" 
                               id="telefone" 
                               
                               required
                               maxlength="11"
                               value="<?= e(\bd\Formatos::telefoneApp($retorno->getTelefone())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo Telefone</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="tipo_telefone" 
                               
                               required
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getTipoTelefone())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Cidade</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="cidade" 
                               
                               required
                               maxlength="100"
                               value="<?= e($retorno->getCidade()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Estado</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="estado" 
                               
                               required
                               maxlength="2"
                               value="<?= e($retorno->getEstado()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Classificacao</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="classificacao" 
                               
                               required
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getClassificacao())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Infoad</label>
                    </div>
                    <div class="controle">
                        <textarea class="memo" 
                               id="infoad" 
                               required
                               maxlength="65535"><?= e($retorno->getInfoad()) ?></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
                        <input type="hidden" id="created" value="<?= e(\bd\Formatos::dataHoraApp($retorno->getCreated())) ?>"> 
                        <input type="hidden" id="modified" value="<?= e(\bd\Formatos::dataHoraApp($retorno->getModified())) ?>"> 
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
    <script src="representante.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>