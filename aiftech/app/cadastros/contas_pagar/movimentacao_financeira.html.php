<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="movimentacao_financeira.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Contas a Pagar</a>/<?= (is_null($codigo)) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <h1>Dados Nota</h1>
                <div class="campos" id="dados_nota">
                    <input type="hidden" id="codigo" value="<?= e(\bd\Formatos::inteiro($codigo)) ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Data</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="data"
                                   id="data_nota"
                                   required
                                   value="<?= e(($compras->getDtNotaFiscal() != '') ? $compras->getDtNotaFiscal() : '') ?>" <?= $disabled ?>>
                            <div class="mensagem"></div>
                        </div>
                    </div>

                    <div class="campo">
                        <div class="rotulo">
                            <label>Número</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="inteiro"
                                   id="numero_nota"
                                   required
                                   value="<?= e(($compras->getNotaFiscal() != '') ? $compras->getNotaFiscal() : '') ?>" <?= $disabled ?>>
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
                                   id="valor_nota"
                                   required
                                   value="<?= e(($compras->getValorNotaFiscal() != '') ? \bd\Formatos::moeda($compras->getValorNotaFiscal()) : '') ?>" <?= $disabled ?>>
                            <div class="mensagem"></div>
                        </div>
                    </div>

                    <div class="campo">
                        <div class="rotulo">
                            <label>Parcela(s)</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="inteiro"
                                   id="parcelas_nota"
                                   required
                                   value="<?= e(($compras->getParcelasNota() != '') ? \bd\Formatos::inteiro($compras->getParcelasNota()) : '') ?>" <?= $disabled ?>>
                            <div class="mensagem"></div>
                        </div>
                    </div>

                    <div class="campo">
                        <div class="rotulo">
                            <label>Meio de Pagamento</label>
                        </div>
                        <div class="controle">
                            <select id="meios_pagamentos" required <?= $disabled ?>>
                                <option value=""></option>
                                <?php foreach ($meios_pagamentos as $k => $v): ?>
                                    <option value="<?= $k ?>" <?= ($compras->getMeiosPagamento() == $k) ? 'selected' : '' ?>><?= e($v) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>

                    <div class="campo oculto">
                        <div class="rotulo">
                            <label>Intervalo</label>
                        </div>
                        <div class="controle">
                            <select id="meios_pagamentos" required <?= $disabled ?>>
                                <option value=""></option>
                                <option value="W">Semanas</option>
                                <option value="M">Meses</option>
                                <option value="Y">Anos</option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>

                    <div class="campo">
                        <div class="rotulo">
                            <label>Observação</label>
                        </div>
                        <div class="controle">
                            <textarea id="observacao"
                                      cols="50"
                                      rows="10" <?= $disabled ?>><?= e($compras->getObservacoes()) ?></textarea>
                            <div class="mensagem"></div>
                        </div>
                    </div>

                    <div class="campo">
                        <div class="rotulo">
                            <label id="rotulo_texto">Anexar Nota</label>
                        </div>
                        <div class="controle arquivo">
                            <label class="file rotulo_arq_nota" for="arquivo_nota" title="Upload de arquivo."></label>
                            <input type="file"
                                   id="arquivo_nota"
                                   name="arquivo_nota"
                                   onchange="seleciona_arquivo(this, 'ctn_arquivos_notas')" <?= $disabled ?>>
                            <div class="mensagem"></div>
                            <div id="ctn_arquivos_notas">
                                <?php if ($compras->getPathNota() != ''): ?>
                                    <div class="a_arquivo">
                                        <?php if ($compras->getSituacao() === 'A'): ?>
                                            <a class="acao excluir" title="Remover o Arquivo."
                                               onclick="remove_arquivo(this)"></a>
                                        <?php endif; ?>
                                        <a data-id="<?= $compras->getId() ?>"
                                           data-path="<?= $compras->getPathNota() ?>"
                                           href="downloadArquivo.php?dir=<?= $compras->getPathNota() ?>"
                                           target="_blank"
                                           title="Visualizar Arquivo.">
                                            <?= e(($compras->getPathNota() != '' ? nomeArquivo($compras->getPathNota()) : '')) ?>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
                <?php if ($compras->getSituacao() == 'A'): ?>
                    <div class="botoes">
                        <a class="botao" onclick="salva('DN')">Salvar Nota</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div>
            <div class="card" id="card_dados_pagamento">
                <h1>Dados Pagamento</h1>
                <div class="campos" id="dados_pagamento">
                    <input type="hidden" id="n_parcelas"
                           value="<?= e(($compras->getParcelasNota() != '') ? \bd\Formatos::inteiro($compras->getParcelasNota()) : '') ?>">
                    <input type="hidden" id="codigo_compra"
                           value="<?= e(($compras->getId() != '') ? \bd\Formatos::inteiro($compras->getId()) : '') ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Tipo</label>
                        </div>
                        <div class="controle">
                            <select id="tipo" required onchange="alteraTipo();" <?= $disabled ?>>
                                <option value=""></option>
                                <?php foreach ($tipos as $k => $v): ?>
                                    <?php if ($k == 'S'): ?>
                                        <option value="<?= $k ?>" <?= ($k == 'S') ? 'selected' : '' ?>><?= $v ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Data</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="data"
                                   id="data"
                                   required <?= $disabled ?>>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Descrição</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class=""
                                   id="descricao"
                                   maxlength="250"
                                   required <?= $disabled ?>>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Documento</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class=""
                                   id="documento"
                                   maxlength="20" <?= $disabled ?>>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo oculto">
                        <div class="rotulo">
                            <label>Contribuinte</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   id="contribuinte"
                                   data-value="<?= hs($compras->getSolicitante()) ?>"
                                   value="<?= e($compras->getSolicitante()) ?>" <?= $disabled ?>>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Conta</label>
                        </div>
                        <div class="controle">
                            <select id="conta" required <?= $disabled ?>>
                                <option value=""></option>
                                <?php
                                foreach ($categorias as $k => $v):
                                    $cat_mae_total = \modelo\CategoriasFinanceira::verificaCategoriaMae($v['id']);
                                    $classe = '';
                                    if ($cat_mae_total > 0) {
                                        $classe = 'negrito';
                                    }
                                    ?>
                                    <option value="<?= hs($v['id']) ?>" class="<?= $classe ?>"
                                        <?= ($classe === 'negrito') ? 'disabled' : '' ?>
                                            data-tipo="<?= hs($v['tipo']) ?>">
                                        <?= hs($v['num'] . ' - ' . $v['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
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
                                   id="valor"
                                   required <?= $disabled ?>>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Centro Custo</label>
                        </div>
                        <div class="controle">
                            <select id="centro_custo" required <?= $disabled ?>>
                                <option value=""></option>
                                <?php foreach ($centros as $centro): ?>
                                    <option value="<?= hs($centro['id']) ?>">
                                        <?= hs($centro['descricao']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Conta Bancária</label>
                        </div>
                        <div class="controle">
                            <select id="conta_financeira" required <?= $disabled ?>>
                                <option value=""></option>
                                <?php foreach ($contas as $k => $v): ?>
                                    <option value="<?= hs($v['id']) ?>"><?= e(($v['tipo_conta'] != 'V') ? $v['nome'] . ' (' . $v['agencia'] . ' - ' . $v['numero'] . ') - ' . $v['banco_descricao'] : $v['nome']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                </div>
                <?php if ($compras->getSituacao() == 'A'): ?>
                    <div class="botoes">
                        <a class="botao" onclick="gerarPagamentos()">Gerar Pagamentos</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div>
            <div class="<?= $oculto ?>" id="card_tbl_movimentacao">
                <div id="tbl_movimentacao">
                    <?php if ($oculto == ''): ?>
                        <table>
                            <thead>
                            <tr>
                                <th class="centro">Id</th>
                                <th class="">Tipo</th>
                                <th class="">Data</th>
                                <th class="">Descrição</th>
                                <th class="">Documento</th>
                                <th class="">Contribuinte</th>
                                <th class="">Conta</th>
                                <th class="direita">Valor</th>
                                <th class="">Centro de Custo</th>
                                <th class="">Conta Bancária</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($retorno as $ret): ?>
                                <tr data-codigo_compra="<?= $codigo ?>">
                                    <td data-titulo="Id" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
                                    <td data-titulo="Tipo" class=""><?= e($tipo[$ret["tipo"]]) ?></td>
                                    <td data-titulo="Data" class=""><?= e(bd\Formatos::dataApp($ret["data"])) ?></td>
                                    <td data-titulo="Descrição" class=""><?= e($ret["descricao"]) ?></td>
                                    <td data-titulo="Documento" class=""><?= e($ret["documento"]) ?></td>
                                    <td data-titulo="Contribuinte" class=""><?= e($ret["contribuinte"]) ?></td>
                                    <td data-titulo="Conta" class=""><?= e($ret["categoria_financeira"]) ?></td>
                                    <td data-titulo="Valor"
                                        class="direita"><?= e(bd\Formatos::moeda($ret["valor"])) ?></td>
                                    <td data-titulo="Centro de Custo" class=""><?= e($ret["centro_custo"]) ?></td>
                                    <td data-titulo="Conta Bancária"
                                        class="cortar"><?= e($ret["conta_financeira"]) ?></td>
                                    <td class="acoes">
                                        <div>
                                            <?php if ($compras->getSituacao() === 'A'): ?>
                                                <?php if (Aut::temPermissao(Aut::$modulos['CONTAS_PAGAR'], \modelo\Permissao::DEL) && strtotime($ret["data"]) >= $hoje): ?>
                                                    <a class="excluir"
                                                       title="Cancelar movimento"
                                                       onclick="cancelar(this)"></a>
                                                <?php endif; ?>
                                                <?php if (Aut::temPermissao(Aut::$modulos['CONTAS_PAGAR'], \modelo\Permissao::REWRITE) && strtotime($ret["data"]) >= $hoje): ?>
                                                    <label class="file"
                                                           for="arquivo_<?= \bd\Formatos::inteiro($ret["id"]) ?>"
                                                           title="Upload de arquivo."></label>
                                                    <input type="file"
                                                           id="arquivo_<?= \bd\Formatos::inteiro($ret["id"]) ?>"
                                                           onchange="selecionaArquivoMovimento(this)">
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <a id="a_acao"
                                               class="detalhe"
                                               title="Mostrar arquivos anexos."
                                               onclick="mostra_arquivos(<?= hs($ret["id"]) ?>)"></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="botoes">
        <a class="botao" onclick="voltar()">Voltar</a>
    </div>

    <div id="j_cancela" class="modal">
        <header>
            <h2>Deseja cancelar este movimento?</h2>
            <a class="fechar" title="Fechar janela"></a>
        </header>
        <section>
            <div class="campos">
                <div class="campo">
                    <div class="rotulo">
                        <label>Justificativa</label>
                    </div>
                    <div class="controle">
                        <textarea id="justificativa" required></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
            </div>
        </section>
        <div class="botoes">
            <a class="botao" id="btn_cancelar" onclick="cancela()">Confirmar</a>
            <a class="botao" onclick="modal.fecha()">Voltar</a>
        </div>
    </div>

    <!--Janela com os arquivos de cada lançamento-->
    <div id="j_arquivos" class="modal">
        <header>
            <h2>Detalhes <span id="spn_arquivos"></span></h2>
            <a class="fechar" title="Fechar janela"></a>
        </header>
        <section>
            <div id="detalhes_grid"></div>
        </section>
        <div class="botoes">
            <a class="botao" onclick="modal.fecha()">Voltar</a>
        </div>
    </div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="movimentacao_financeira.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>