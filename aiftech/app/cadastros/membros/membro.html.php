<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
    <link rel="stylesheet" href="membro.css">
<?php $template->fimCss() ?>
<?php $template->iniMain() ?>
    <h1>
        <div>
            <a onclick="voltar()">Membros</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?>
        </div>
        <div id="info">
            <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
               title="Visualizar Manual."></a>
        </div>
    </h1>
    <div class="container">
        <div>
            <div class="card">
                <h1>Dados pessoais</h1>
                <div class="campos">
                    <input type="hidden" id="tabela" value="membros">
                    <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                    <input type="hidden" id="img_foto_path" value="<?= e($foto) ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label>CPF</label>
                        </div>
                        <div class="controle">
                            <input type="text" class="cpf" id="cpf" required maxlength="20" onblur="validaUsuario(this)"
                                   value="<?= e(\bd\Formatos::cpfApp($retorno->getCpf())) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>RG</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="rg"
                                   maxlength="20"
                                   value="<?= e($retorno->getRg()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>

                    <div class="campo">
                        <div class="rotulo">
                            <label>Data Expedição</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="data"
                                   id="data_expedicao"
                                   maxlength="10"
                                   value="<?= e($retorno->getDataExpedicao()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>

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
                            <label>Sexo</label>
                        </div>
                        <div class="controle">
                            <select id="sexo">
                                <option value=""></option>
                                <option value="M" <?= ($retorno->getSexo() == 'M') ? 'selected' : '' ?>>Masculino
                                </option>
                                <option value="F" <?= ($retorno->getSexo() == 'F') ? 'selected' : '' ?>>Feminino
                                </option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Data nascimento</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="data"
                                   id="datanascimento"
                                   maxlength="10"
                                   value="<?= e(\bd\Formatos::dataApp($retorno->getDatanascimento())) ?>"
                                   required>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Naturalidade</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="naturalidade"
                                   maxlength="100"
                                   value="<?= e($retorno->getNaturalidade()) ?>">
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
                                    data-descricao="sigla">
                                <option value=""></option>
                                <?php foreach ($estados as $tbl): ?>
                                    <option value="<?= e($tbl["id"]) ?>"
                                        <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getEstadoId()))) ? "selected" : "" ?>><?= ucwords($tbl["sigla"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <!-- Valores para estado civil:
                         0 - Solteiro(a) - quem nunca se casou, ou que teve o casamento anulado.
                         1 - Casado(a) - quem contraiu matrimônio, independente do regime de bens adotado.
                         2 - Divorciado(a) - após a homologação do divórcio pela justiça ou por uma escritura pública.
                         3 - Viúvo(a) - pessoa cujo cônjuge faleceu.
                         4 - Separado(a) - pessoa cujo vínculo jurídico do casamento existe, mas foi dissolvida por escritura pública ou decisão judicial a sociedade conjugal.
                    -->
                    <div class="campo">
                        <div class="rotulo">
                            <label>Estado civil</label>
                        </div>
                        <div class="controle">
                            <select id="estadocivil" onchange="mostraCampo(this, 'campo_dt_casamento')">
                                <option value=""></option>
                                <option value="0" <?= ($retorno->getEstadoCivil() === 0) ? 'selected' : '' ?>>
                                    Solteiro(a)
                                </option>
                                <option value="1" <?= ($retorno->getEstadoCivil() === 1) ? 'selected' : '' ?>>
                                    Casado(a)
                                </option>
                                <option value="2" <?= ($retorno->getEstadoCivil() === 2) ? 'selected' : '' ?>>
                                    Divorciado(a)
                                </option>
                                <option value="3" <?= ($retorno->getEstadoCivil() === 3) ? 'selected' : '' ?>>
                                    Viúvo(a)
                                </option>
                                <option value="4" <?= ($retorno->getEstadoCivil() === 4) ? 'selected' : '' ?>>
                                    Separado(a)
                                </option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>

                    <div class="campo" id="campo_dt_casamento">
                        <div class="rotulo">
                            <label>Data casamento</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="data"
                                   id="data_casamento"
                                   maxlength="10"
                                   value="<?= e($retorno->getDataCasamento()) ?>">
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
                                   maxlength="150"
                                   value="<?= e($retorno->getEmail()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Fone fixo</label>
                        </div>
                        <div class="controle">
                            <input type="tel"
                                   class="telefone"
                                   id="fone"
                                   maxlength="20"
                                   value="<?= e($retorno->getFone()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Celular</label>
                        </div>
                        <div class="controle">
                            <input type="tel"
                                   class="telefone"
                                   id="cel"
                                   maxlength="20"
                                   value="<?= e(\bd\Formatos::telefoneApp($retorno->getCel())) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label id="rotulo_texto">Anexar foto (jpg)</label>
                        </div>
                        <div class="controle arquivo">
                            <label class="file rotulo_arq" for="arquivo_foto"
                                   title="Upload da foto Digitalizada."></label>
                            <input type="file" id="arquivo_foto" name="arquivo" onclick="limpaCampoArquivo(this)"
                                   onchange="seleciona_arquivo(this)"
                                <?= ($foto) ? 'disabled' : '' ?>>
                            <div class="mensagem"></div>
                            <div id="ctn_foto">
                                <?php /*if ($id != '' && !is_null($id) && !is_null($foto)): */ ?>
                                <div class="a_arquivo">
                                    <a class="acao excluir" title="Remover o Arquivo."
                                       onclick="remove_arquivo(this)"></a>
                                    <img id="img_foto" class="imagem" src="<?= SITE . ($foto) ?>">
                                </div>
                                <?php /*endif; */ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card">
                <h1>Endereço</h1>
                <div class="campos">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Cep</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="cep"
                                   id="cep"
                                   maxlength="15"
                                   onblur="consultaCep(this)"
                                   data-id="<?= e(($end_flag) ? $end->getId() : '') ?>"
                                   value="<?= e(($end_flag) ? $end->getCep() : '') ?>"
                            >
                            <div id="msg"></div>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Logradouro</label>
                        </div>
                        <div class="controle">
                            <input type="text" id="logradouro"
                                   value="<?= e(($end_flag) ? $end->getLogradouro() : '') ?>"
                                   data-value="<?= e(($end_flag) ? $end->getLogradouro() : '') ?>"
                                   onfocus="validaEndereco()">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Bairro</label>
                        </div>
                        <div class="controle">
                            <input type="text" id="bairro" value="<?= e(($end_flag) ? $end->getBairro() : '') ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Cidade</label>
                        </div>
                        <div class="controle">
                            <input type="text" id="localidade"
                                   value="<?= e(($end_flag) ? $end->getLocalidade() : '') ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Estado</label>
                        </div>
                        <div class="controle">
                            <select id="uf">
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
                            <input type="text" id="numero" value="<?= e($retorno->getNumero()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Complemento</label>
                        </div>
                        <div class="controle">
                            <input type="text" id="complemento" value="<?= e($retorno->getComplemento()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo oculto">
                        <div class="rotulo">
                            <label>Núcleo</label>
                        </div>
                        <div class="controle">
                            <select id="nucleo">
                                <option value=""></option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card">
                <h1>Status / Frequência</h1>
                <div class="campos">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Frequência</label>
                        </div>
                        <div class="controle">
                            <select id="frequencia" required>
                                <option value=""></option>
                                <?php
                                foreach ($frequencias as $key => $value):
                                    $status = '';
                                    switch ($value['status']) {
                                        case 'A':
                                            if ($value['quorum'] == 'S') {
                                                $status = 'Ativo';
                                            } else {
                                                $status = 'Ativo - Não Quórum';
                                            }
                                            break;
                                        case 'I':
                                            if ($value['quorum'] == 'S') {
                                                $status = 'Inativo';
                                            } else {
                                                $status = 'Inativo - Não Quórum';
                                            }
                                            break;
                                    }
                                    ?>
                                    <option value="<?= e($value['id']) ?>" <?= ($retorno->getFrequencia()) === $value['id'] ? 'selected' : '' ?>><?= e($value['frequencia'] . ' - ' . $status) ?></option>
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
                            <select id="locais" required>
                                <option value=""></option>
                                <?php foreach ($locais as $k => $v): ?>
                                    <option value="<?= e($v['id']) ?>" <?= ($retorno->getLocalId() == $v['id']) ? 'selected' : '' ?>><?= e($v['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                </div>
                <h1>Escolaridade / Profissão</h1>
                <div class="campos">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Escolaridade</label>
                        </div>
                        <div class="controle">
                            <select id="escolaridade_id"
                                    data-tabela="escolaridades"
                                    data-codigo="id"
                                    data-descricao="descricao">
                                <option value=""></option>
                                <?php foreach ($escolaridades as $tbl): ?>
                                    <option value="<?= e($tbl["id"]) ?>"
                                        <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getEscolaridadeId()))) ? "selected" : "" ?>><?= ucwords($tbl["descricao"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Profissão / Formação</label>
                        </div>
                        <div class="controle">
                            <select id="profissao_id"
                                    data-tabela="profissoes"
                                    data-codigo="id"
                                    data-descricao="nome">
                                <option value=""></option>
                                <?php foreach ($profissoes as $tbl): ?>
                                    <option value="<?= e($tbl["id"]) ?>"
                                        <?= ($tbl["id"] == e(\bd\Formatos::inteiro($retorno->getProfissaoId()))) ? "selected" : "" ?>><?= ucwords($tbl["nome"]) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Empresa</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="empresa"
                                   maxlength="150"
                                   value="<?= e($retorno->getEmpresa()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card">
                <h1>Vida Cristã</h1>
                <div class="campos">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Data batismo</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="data"
                                   id="databatismo"
                                   maxlength="10"
                                   value="<?= e(\bd\Formatos::dataApp($retorno->getDatabatismo())) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Igreja batismo</label>
                        </div>
                        <div class="controle">
                            <input type="text" id="igrejabatismo"
                                   data-id="<?= e($igreja_batismo->getId()) ?>"
                                   value="<?= e($igreja_batismo->getNome()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Pastor batismo</label>
                        </div>
                        <div class="controle">
                            <input type="text" id="pastorbatismo"
                                   data-id="<?= e($pastor->getId()) ?>"
                                   value="<?= e($pastor->getNome()) ?>"
                                   onblur="validaCombo(this, 'pastor')">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <?php if (!empty($atas)): ?>
                        <div class="campo">
                            <div class="rotulo">
                                <label>Ata batismo</label>
                            </div>
                            <div class="controle">
                                <select id="ata_batismo">
                                    <option value=""></option>
                                    <?php foreach ($atas as $key => $value): ?>
                                        <option value="<?= e($value['id']) ?>" <?= ($retorno->getAtaBatismo() === $value['id']) ? 'selected' : '' ?>><?= e($value['num']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="mensagem"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Última igreja</label>
                        </div>
                        <div class="controle">
                            <!--<select id="ultimaigreja">
                                <option value=""></option>
                                <?php /*foreach ($igrejas as $key => $value): */ ?>
                                    <option value="<? /*= e($value['id']) */ ?>" <? /*= ($retorno->getUltimaigreja() === $value['id']) ? 'selected' : '' */ ?>><? /*= e($value['nome']) */ ?></option>
                                <?php /*endforeach; */ ?>
                            </select>-->
                            <input type="text" id="ultimaigreja"
                                   data-id="<?= e($ultima_igreja->getId()) ?>"
                                   value="<?= e($ultima_igreja->getNome()) ?>"
                                   onkeyup="filtraCombo(event, this)"
                                   onblur="validaCombo(this, 'igreja')">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Data membresia</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="data"
                                   id="datamembro"
                                   maxlength="10"
                                   value="<?= e(\bd\Formatos::dataApp($retorno->getDatamembro())) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Igrejas anteriores</label>
                        </div>
                        <div class="controle">
                            <input type="text" id="sel_ig_ant">
                            <div id="ctn_igreja_anterior">
                                <?php foreach ($ig_ant as $k => $v): ?>
                                    <div class="a_igreja_anterior">
                                        <a data-id="<?= e($v['id']) ?>" class="acao excluir"
                                           onclick="remover(this)"></a>
                                        <label><?= e($v['nome']) ?></label>&nbsp;
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Tipo</label>
                        </div>
                        <div class="controle">
                            <select id="tipo" required>
                                <option value=""></option>
                                <option value="M" <?= ("M" == strtoupper(e($retorno->getTipo()))) ? "selected" : "" ?>><?= ucwords("Membro") ?></option>
                                <option value="V" <?= ("V" == strtoupper(e($retorno->getTipo()))) ? "selected" : "" ?>><?= ucwords("Visitante") ?></option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Dons</label>
                        </div>
                        <div class="controle">

                            <select id="sel_dons" onchange="adicionaLinha(this, 'ctn_dom')">
                                <option value=""></option>
                                <?php foreach ($dons as $key => $value): ?>
                                    <option value="<?= e($value['id']) ?>"><?= e($value['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>

                            <div id="ctn_dom">
                                <?php foreach ($dom_membro as $k => $v): ?>
                                    <div class="a_dom">
                                        <a data-id="<?= e($v['dom_id']) ?>" class="acao excluir"
                                           onclick="remover(this)"></a>
                                        <label><?= e($v['nome']) ?></label>&nbsp;
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <input type="hidden" id="empresa_id"
                           value="<?= e(\bd\Formatos::inteiro($retorno->getEmpresaId())) ?>">
                    <input type="hidden" id="user_id" value="<?= e(\bd\Formatos::inteiro($retorno->getUserId())) ?>">
                    <input type="hidden" id="created"
                           value="<?= e(\bd\Formatos::dataHoraApp($retorno->getCreated())) ?>">
                    <input type="hidden" id="modified"
                           value="<?= e(\bd\Formatos::dataHoraApp($retorno->getModified())) ?>">
                </div>
            </div>
        </div>
        <div>
            <div class="card">
                <h1>Ministérios Interesse</h1>
                <div class="campos">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Ministério(s)</label>
                        </div>
                        <div class="controle">
                            <select id="sel_min_int" onchange="adicionaLinha(this, 'ctn_dep_interesse')">
                                <option value=""></option>
                                <?php foreach ($dep_interesse as $key => $value): ?>
                                    <option value="<?= e($value['id']) ?>"><?= e($value['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div id="ctn_dep_interesse">
                                <?php foreach ($deps as $k => $v): ?>
                                    <div class="a_dep_interesse">
                                        <a data-id="<?= e($v['id']) ?>" class="acao excluir"
                                           onclick="remover(this)"></a>
                                        <label><?= e($v['nome']) ?></label>&nbsp;
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="card">
                <h1>Cargos</h1>
                <div class="campos">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Cargo</label>
                        </div>
                        <div class="controle">
                            <select id="sel_cargo" onchange="carregaDepartamentos(this)">
                                <option value=""></option>
                                <?php foreach ($cargos as $key => $value): ?>
                                    <option value="<?= e($value['id']) ?>"><?= e($value['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Departamento</label>
                        </div>
                        <div class="controle">
                            <select id="sel_cargo_dep">
                                <option value=""></option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Período</label>
                        </div>
                        <div class="controle">
                            <input type="text" class="inteiro" id="periodo" maxlength="4" placeholder="AAAA">
                            <a class="botao" id="btn_cargo" onclick="adicionaCargo()">Adicionar</a>
                            <div class="mensagem"></div>
                            <div id="ctn_cargos">
                                <table id="tbl_cargos" class="<?= (!$flag_cargos_ocupados) ? 'esconde' : '' ?>">
                                    <thead>
                                    <tr>
                                        <th class="">Período</th>
                                        <th>Cargo</th>
                                        <th>Departamento</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($flag_cargos_ocupados): ?>
                                        <?php foreach ($cargos_ocupados as $k => $v): ?>
                                            <tr data-cargoid="<?= e($v['cargo_id']) ?>"
                                                data-depid="<?= e($v['departamento_id']) ?>"
                                                data-periodo="<?= e($v['periodo']) ?>"
                                                data-ativo="<?= e($v['ativo']) ?>">
                                                <td data-titulo="Período" class=""><?= e($v["periodo"]) ?></td>
                                                <td data-titulo="Cargo"><?= e($v["cargo"]) ?></td>
                                                <td data-titulo="Departamento"><?= e($v["departamento"]) ?></td>
                                                <td class="acoes">
                                                    <?php /*if ($v["ativo"] == 'S'): */ ?>
                                                    <div>
                                                        <a class="<?= ($v["ativo"] == 'S') ? 'ligado' : 'desligado' ?>"
                                                           title="<?= ($v["ativo"] == 'S') ? 'Desativar' : 'Ativar' ?>"
                                                           onclick="liga_desliga(this)"></a>
                                                    </div>
                                                    <?php /*endif; */ ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="botoes">
        <a class="botao" onclick="salva('<?= e($tp_salvamento) ?>')">Salvar</a>
        <a class="botao" onclick="voltar()">Voltar</a>
        <?php if (Aut::temPerfil(Aut::PERFIL_MASTER)): ?>
            <!--<a class="botao" onclick="salvaArquivo(<? /*= e($retorno->getId())*/ ?>)">Salva foto</a>-->
        <?php endif; ?>
    </div>

    <div id="j_enderecos" class="combo flutuante">
        <div id="detalhes_grid">
            <table>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div id="j_pastorbatismo" class="combo flutuante">
        <div id="grid_pastorbatismo">
            <table>
                <tbody>
                <?php foreach ($pastores as $k => $v): ?>
                    <tr data-id="<?= hs($v["id"]) ?>"
                        data-nome="<?= hs($v['nome']) ?>"
                        data-campo="pastorbatismo">
                        <td data-value="<?= e($v["nome"]) ?>"><?= e($v["nome"]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="j_igrejabatismo" class="combo flutuante">
        <div id="grid_igrejabatismo">
            <table>
                <tbody>
                <?php foreach ($igrejas as $key => $value): ?>
                    <tr data-id="<?= hs($value['id']) ?>"
                        data-nome="<?= hs($value['nome']) ?>"
                        data-campo="igrejabatismo">
                        <td data-value="<?= hs($value['id']) ?>"><?= e($value['nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="j_ultimaigreja" class="combo flutuante">
        <div id="grid_ultimaigreja">
            <table>
                <tbody>
                <?php foreach ($igrejas as $key => $value): ?>
                    <tr data-id="<?= hs($value['id']) ?>"
                        data-nome="<?= hs($value['nome']) ?>"
                        data-campo="ultimaigreja">
                        <td><?= e($value['nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="j_sel_ig_ant" class="combo flutuante">
        <div id="grid_sel_ig_ant">
            <table>
                <tbody>
                <?php foreach ($igrejas as $key => $value): ?>
                    <tr data-id="<?= hs($value['id']) ?>"
                        data-nome="<?= hs($value['nome']) ?>"
                        data-campo="sel_ig_ant">
                        <td><?= e($value['nome']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="membro.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>