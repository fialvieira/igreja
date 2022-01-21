<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
    <link rel="stylesheet" href="contas_financeira.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>
    <h1><a onclick="voltar()">Contas Bancárias</a> / <?= (!$filtro[0]) ? "Novo" : "Alterar" ?> </h1>
    <div class="container">
        <div>
            <div class="card">
                <div class="campos">
                    <input type="hidden" id="tabela" value="contas_financeira">
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
                            <label>Descrição</label>
                        </div>
                        <div class="controle">
                        <textarea class="memo"
                                  id="descricao"

                                  maxlength="65535"><?= e($retorno->getDescricao()) ?></textarea>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Banco</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   id="banco_id"
                                   value="<?= e(($retorno->getNomeBanco() != '') ? $retorno->getNomeBanco() : '') ?>"
                                   data-id="<?= e(($retorno->getBancoId() != '') ? \bd\Formatos::inteiro($retorno->getBancoId()) : '') ?>"
                                   data-value="<?= e(($retorno->getNomeBanco() != '') ? $retorno->getNomeBanco() : '') ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Agência</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="agencia"


                                   maxlength="10"
                                   value="<?= e($retorno->getAgencia()) ?>">
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


                                   maxlength="10"
                                   value="<?= e($retorno->getNumero()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Variaçâo</label>
                        </div>
                        <div class="controle">
                            <input type="text"
                                   class="texto"
                                   id="variacao"


                                   maxlength="5"
                                   value="<?= e($retorno->getVariacao()) ?>">
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Tipo Conta</label>
                        </div>
                        <div class="controle">
                            <select id="tipo_conta">
                                <option value=""></option>
                                <option value="V"
                                    <?= ("V" == strtoupper(e($retorno->getTipoConta()))) ? "selected" : "" ?>><?= ucwords("Caixa") ?></option>
                                <option value="C"
                                    <?= ("C" == strtoupper(e($retorno->getTipoConta()))) ? "selected" : "" ?>><?= ucwords("Corrente") ?></option>
                                <option value="A"
                                    <?= ("A" == strtoupper(e($retorno->getTipoConta()))) ? "selected" : "" ?>><?= ucwords("Aplicação") ?></option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Tipo Aplicação</label>
                        </div>
                        <div class="controle">
                            <select id="tipo_aplicacao">
                                <option value=""></option>
                                <option value="P"
                                    <?= ("P" == strtoupper(e($retorno->getTipoAplicacao()))) ? "selected" : "" ?>><?= ucwords("Própria") ?></option>
                                <option value="T"
                                    <?= ("T" == strtoupper(e($retorno->getTipoAplicacao()))) ? "selected" : "" ?>><?= ucwords("Transitória") ?></option>
                            </select>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                    <div class="campo">
                        <div class="rotulo">
                            <label>Saldo Inicial</label>
                        </div>
                        <div class="controle">
                            <input type="text" class="real"
                                   id="saldo_inicial"
                                   value="<?= e(\bd\Formatos::moeda($retorno->getSaldoInicial())) ?>">
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
                <div class="botoes">
                    <a class="botao" onclick="salva()">Salvar</a>
                    <a class="botao" onclick="voltar()">Voltar</a>
                </div>
            </div>
        </div>
    </div>
    <div id="j_bancos" class="combo flutuante">
        <div id="grid_bancos">
            <table>
                <tbody>
                <?php foreach ($bancos as $k => $v): ?>
                    <tr data-id="<?= hs($v["id"]) ?>"
                        data-nome="<?= hs($v['nome']) ?>"
                        data-campo="banco_id">
                        <td data-value="<?= e($v['numero'] . ' - ' . $v["nome"]) ?>"><?= e($v['numero'] . ' - ' . $v["nome"]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="contas_financeira.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>