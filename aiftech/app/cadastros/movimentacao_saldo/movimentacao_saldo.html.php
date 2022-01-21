<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="movimentacao_saldo.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Movimentação Saldo</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="codigo" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label>Valor</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="real"
                                   id="valor"
                                   required
                                   onblur="atualizaSaldos()"
                                   value="<?= e(\bd\Formatos::moeda($retorno->getValor())) ?>">
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
                                   value="<?= e(\bd\Formatos::dataApp($retorno->getData())) ?>">
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
                            <label>Conta Origem</label>
                        </div>
                        <div class="controle">
                            <select id="conta_origem" required <?= e($disabled) ?> onchange="carregaSaldo(this)">
                                <option value=""></option>
                                <?php foreach ($contas as $k => $v): ?>
                                    <option value="<?= e($v['id']) ?>"
                                        <?= ($v['id'] == $retorno->getContasFinanceiraOrigemId()) ? 'selected' : '' ?>><?= e(($v['tipo_conta'] != 'V') ? $v['nome'] . ' (' . $v['agencia'] . ' - ' . $v['numero'] . ') - ' . $v['banco_descricao'] : $v['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Saldo Origem</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="real"
                                   id="saldo"
                                   disabled>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Conta Destino</label>
                        </div>
                        <div class="controle">
                            <select id="conta_destino" required onchange="carregaSaldo(this)">
                                <option value=""></option>
                                <?php foreach ($contas as $k => $v): ?>
                                    <option value="<?= e($v['id']) ?>"
                                        <?= ($v['id'] == $retorno->getContasFinanceiraDestinoId()) ? 'selected' : '' ?>><?= e(($v['tipo_conta'] != 'V') ? $v['nome'] . ' (' . $v['agencia'] . ' - ' . $v['numero'] . ') - ' . $v['banco_descricao'] : $v['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Saldo Destino</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="real"
                                   id="saldo_destino"
                                   disabled>
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
    <script src="movimentacao_saldo.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>