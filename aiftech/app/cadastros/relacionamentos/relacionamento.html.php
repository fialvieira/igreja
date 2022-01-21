<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="relacionamento.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<!--<h1><a href="ndex.php">Relacionamentos</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>-->
<h1><a onclick="voltar()">Relacionamentos</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="relacionamentos">
                <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>"> 
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
                <div class="campo">
                    <div class="rotulo">
                        <label>Tiporelacionamento</label>
                    </div>
                    <div class="controle">
                        <select id="tiporelacionamento_id"
                                data-tabela="tiporelacionamentos"
                                data-codigo="id"
                                data-descricao="descricao"
                                >   
                            <option value=""></option>     
                        <?php foreach ($tiporelacionamentos as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getTiporelacionamentoId())))? "selected" : "" ?>><?= ucwords($tbl["descricao"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Membro2</label>
                    </div>
                    <div class="controle">
                        <select id="membro2_id"
                                data-tabela="membros"
                                data-codigo="id"
                                data-descricao="nome"
                                >   
                            <option value=""></option>     
                        <?php foreach ($membros as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getMembro2Id())))? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                        <input type="hidden" id="empresa_id" value="<?= e(\bd\Formatos::inteiro($retorno->getEmpresaId())) ?>"> 
                        <input type="hidden" id="user_id" value="<?= e(\bd\Formatos::inteiro($retorno->getUserId())) ?>"> 
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
    <script src="relacionamento.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>