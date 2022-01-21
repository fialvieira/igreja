<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="movimentacao_financeira.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
<h1><a onclick="voltar()">Lançamentos Diários</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="codigo" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo</label>
                    </div>
                    <div class="controle">
                        <select id="tipo" required onchange="alteraTipo();">
                            <option value=""></option>
                            <?php foreach ($tipos as $k => $v): ?>
                                <option value="<?= $k ?>" <?= ($k == $retorno->getTipo()) ? 'selected' : '' ?>><?= $v ?></option>
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
                               required
                               value="<?= e($retorno->getData()) ?>">
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
                               required
                               value="<?= e($retorno->getDescricao()) ?>">
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
                               maxlength="20"
                               value="<?= e($retorno->getDocumento()) ?>">
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
                               data-value="<?= hs($retorno->getMembroId()) ?>"
                               value="<?= e($retorno->getMembro()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Conta</label>
                    </div>
                    <div class="controle">
                        <select id="conta" onchange="carregaContasFinanceiras(this)" required>
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
                                <?= ($v['id'] == $retorno->getCategoriaFinanceira()) ? 'selected' : '' ?>
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
                               required
                               value="<?= e($retorno->getValor()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Centro Custo</label>
                    </div>
                    <div class="controle">
                        <select id="centro_custo" required>
                            <option value=""></option>
                            <?php foreach ($centros as $centro): ?>
                                <option value="<?= hs($centro['id']) ?>" <?= ($centro['id'] == $retorno->getCentroCusto()) ? 'selected' : (!$retorno->getCentroCusto() && ($centro['principal'] == 'S') ? 'selected' : '') ?>>
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
                        <select id="conta_financeira" required>
                            <option value=""></option>
                            <?php foreach ($contas as $k => $v): ?>
                                <option value="<?= hs($v['id']) ?>" <?= ($v['id'] == $retorno->getContasFinanceiraId()) ? 'selected' : '' ?>><?= e(($v['tipo_conta'] != 'V') ? $v['nome'] . ' (' . $v['agencia'] . ' - ' . $v['numero'] . ') - ' . $v['banco_descricao'] : $v['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label id="rotulo_texto">Anexar Arquivos</label>
                    </div>
                    <div class="controle arquivo">
                        <?php // if ($retorno->getFinalizado() != 'S'): ?>
                            <label class="file rotulo_arq" for="arquivo" title="Upload de arquivo."></label>
                            <input type="file" id="arquivo" name="arquivo" onchange="seleciona_arquivo(this)">
                        <?php // endif; ?>
                        <div class="mensagem"></div>
                        <div id="ctn_arquivos">
                            <?php foreach ($arquivos as $arquivo): ?>
                                <div class="a_arquivo">
                                    <?php // if ($retorno->getFinalizado() != 'S'): ?>
                                        <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>
                                    <?php // endif; ?>
                                    <a data-id="<?= hs($arquivo['id']) ?>"
                                       data-path="<?= $arquivo['path'] ?>"
                                       href="downloadArquivo.php?dir=<?= $arquivo['path'] ?>" 
                                       target="_blank" 
                                       title="Visualizar Arquivo.">
                                           <?= e($arquivo['nome']) ?>
                                    </a>
                                </div>  
                            <?php endforeach; ?>              
                        </div>            
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

<!--Janela com lista dos membros-->
<div id="j_membros" class="combo flutuante">
    <div>
        <table>
            <tbody>
                <?php foreach ($arrMembroCargos as $membro) : ?>
                    <tr>
                        <td data-value="<?= hs($membro[0]["id"]) ?>"><?= e($membro[0]["nome"]) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script src="movimentacao_financeira.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>