<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="endereco.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<!--<h1><a href="ndex.php">Endereços</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>-->
<h1><a onclick="voltar()">Endereços</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="enderecos">
                <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>"> 
                <div class="campo">
                    <div class="rotulo">
                        <label>Logradouro</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="logradouro" 
                               
                               required
                               maxlength="70"
                               value="<?= e($retorno->getLogradouro()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Numero</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="numero" 
                               
                               required
                               maxlength="10"
                               value="<?= e($retorno->getNumero()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Complemento</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="complemento" 
                               
                               
                               maxlength="70"
                               value="<?= e($retorno->getComplemento()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Bairro</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="bairro" 
                               
                               required
                               maxlength="45"
                               value="<?= e($retorno->getBairro()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>CEP</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="cep" 
                               id="cep" 
                               
                               required
                               maxlength="10"
                               value="<?= e(\bd\Formatos::cepApp($retorno->getCep())) ?>">
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
                        <select id="estado_id"
                                data-tabela="estados"
                                data-codigo="id"
                                data-descricao="sigla"
                                >   
                            <option value=""></option>     
                        <?php foreach ($estados as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getEstadoId())))? "selected" : "" ?>><?= ucwords($tbl["sigla"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Membro</label>
                    </div>
                    <div class="controle">
                        <select id="membro_id"
                                data-tabela="membros"
                                data-codigo="id"
                                data-descricao="nome"
                                >   
                            <option value=""></option>     
                        <?php foreach ($membros as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getMembroId())))? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                        <input type="hidden" id="user_id" value="<?= e(\bd\Formatos::inteiro($retorno->getUserId())) ?>"> 
                        <input type="hidden" id="empresa_id" value="<?= e(\bd\Formatos::inteiro($retorno->getEmpresaId())) ?>"> 
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
    <script src="endereco.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>