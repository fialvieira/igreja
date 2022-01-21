<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="bem.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>
  <div>
    <a onclick="voltar()">Bens</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> 
  </div>
  <div id="info">
    <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank" title="Visualizar Manual."></a>
  </div>
</h1>
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
                               maxlength="200"
                               value="<?= e($retorno->getNome()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Identificação</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="identificacao"
                               required
                               maxlength="100"
                               value="<?= e($retorno->getIdentificacao()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Nº Série</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="num_serie" 
                               maxlength="100"
                               value="<?= e($retorno->getNumSerie()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Nº Ativo</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="num_ativo" 
                               required
                               maxlength="100"
                               value="<?= e($retorno->getNumAtivo()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Marca</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="" 
                               id="marca" 
                               maxlength="200"
                               value="<?= e($retorno->getMarca()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Modelo</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="" 
                               id="modelo" 
                               maxlength="200"
                               value="<?= e($retorno->getModelo()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Descrição</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="descricao" 
                               maxlength="500"
                               value="<?= e($retorno->getDescricao()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Data Compra</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="data" 
                               id="data_compra" 
                               value="<?= e(\bd\Formatos::dataApp($retorno->getDataCompra())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Término Garantia</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="data" 
                               id="garantia" 
                               value="<?= e(\bd\Formatos::dataApp($retorno->getGarantia())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Valor</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="real" 
                               id="valor_unitario" 
                               data-casas="2"
                               maxlength="21"
                               value="<?= e(\bd\Formatos::real($retorno->getValorUnitario())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Departamento</label>
                    </div>
                    <div class="controle">
                        <select id="departamento_id"
                                data-tabela="departamentos"
                                data-codigo="id"
                                data-descricao="nome"
                                >   
                            <option value=""></option>     
                        <?php foreach ($departamentos as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == hs($retorno->getDepartamentoId()))? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Local</label>
                    </div>
                    <div class="controle">
                        <select id="local_id"
                                data-tabela="local"
                                data-codigo="id"
                                data-descricao="nome"
                                >   
                            <option value=""></option>     
                        <?php foreach ($locais as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == hs($retorno->getLocalId()))? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo do Bem</label>
                    </div>
                    <div class="controle">
                        <select id="tipo_bem_id"
                                data-tabela="tipo_bens"
                                data-codigo="id"
                                data-descricao="nome"
                                >   
                            <option value=""></option>     
                        <?php foreach ($tipo_bens as $tbl): ?>
                            <option value="<?= e($tbl["id"]) ?>" 
                                    <?= ($tbl["id"] == hs($retorno->getTipoBemId()))? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Observação</label>
                    </div>
                    <div class="controle">
                        <textarea class="memo" 
                               id="observacao" 
                               maxlength="65535"><?= e($retorno->getObservacao()) ?></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
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
    <script src="bem.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>