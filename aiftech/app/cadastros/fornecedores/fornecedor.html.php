<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="fornecedor.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

    <h1>
        <div>
            <a onclick="voltar()">Fornecedores</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?>
        </div>
        <div id="info">
            <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
               title="Visualizar Manual."></a>
        </div>
    </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="tabela" value="fornecedores">
                    <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                    <input type="hidden" id="end_id">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Nome Fantasia</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="nome_fantasia"
                                   required
                                   maxlength="150"
                                   value="<?= e($retorno->getNomeFantasia()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Razão Social</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="razao_social"
                                   required
                                   maxlength="150"
                                   value="<?= e($retorno->getRazaoSocial()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Cnpj</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="cnpj"
                                   id="cnpj"
                                   required
                                   maxlength="15"
                                   value="<?= e($retorno->getCnpj()) ?>">
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
                                   maxlength="100"
                                   value="<?= e($retorno->getEmail()) ?>">
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
                                   maxlength="11"
                                   value="<?= e($retorno->getTelefone()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Celular</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="telefone2"
                                   maxlength="11"
                                   value="<?= e($retorno->getTelefone2()) ?>">
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
                                   maxlength="8"
                                   onblur="consultaCep(this)"
                                   value="<?= e(($end_flag) ? $end->getCep() : '') ?>">
                            <div id="msg"></div>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Logradouro</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="logradouro"
                                   maxlength="150"
                                   value="<?= e(($end_flag) ? $end->getLogradouro() : '') ?>"
                                   disabled>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Bairro</label>
                        </div>
                        <div class="controle">
                            <input type="text" id="bairro" value="<?= e(($end_flag) ? $end->getBairro() : '') ?>"
                                   disabled>
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
                                   id="localidade"
                                   maxlength="100"
                                   value="<?= e(($end_flag) ? $end->getLocalidade() : '') ?>" disabled>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Estado</label>
                        </div>
                        <div class="controle">
                            <select id="uf" disabled>
                                <option value=""></option>
                                <?php foreach ($estados as $k => $v):
                                    if ($end_flag) {
                                        if ($v['id'] == $end->getEstado()) {
                                            $selecionado = 'selected';
                                        } else {
                                            $selecionado = '';
                                        }
                                    } else {
                                        $selecionado = '';
                                    }
                                    ?>
                                    <option value="<?= $v['id'] ?>" <?= $selecionado ?>><?= e($v['sigla']) ?></option>
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
                            <input type="text" class="inteiro" id="numero" value="<?= e($retorno->getNumero()) ?>">
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
                                   maxlength="50"
                                   value="<?= e($retorno->getComplemento()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Tipo</label>
                        </div>
                        <div class="controle">
                            <select id="tipo"
                                    data-tabela="tipo_fornecedores"
                                    data-codigo="id"
                                    data-descricao="descricao">
                                <option value=""></option>
                                <?php foreach ($tipos as $tbl): ?>
                                    <option value="<?= e($tbl["id"]) ?>"
                                        <?= ($tbl["id"] == e($retorno->getTipo())) ? "selected" : "" ?>><?= ucwords($tbl["descricao"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <!--                        <input type="text"
                               class="inteiro" 
                               id="tipo" 
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getTipo())) ?>">-->
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <!--<input type="hidden" id="empresa_id" value="<?= e(\bd\Formatos::inteiro($retorno->getEmpresaId())) ?>">-->
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
    <script src="fornecedor.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>