<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
    <link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>
<?php $template->iniMain() ?>
    <div class="container-grid">
        <h1>
            <div>Transferência Plano de Contas</div>
            <div id="info">
                <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
                   title="Visualizar Manual."></a>
            </div>
        </h1>
        <div class="qbe">
            <div class="campos campos-horizontais">
                <div class="campo">
                    <div class="rotulo">
                        <label>Plano de Conta</label>
                    </div>
                    <div class="controle">
                        <select id="categoria" onchange="filtra()">
                            <option></option>
                            <?php foreach ($planos as $plano): ?>
                                <option value="<?= hs($plano['codigo']) ?>"><?= e($plano['descricao']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mensagem"></div>
                </div>
            </div>
        </div>
        <div id="ctn_totalizador">
            <span id="total_registros"></span>
        </div>
        <div class="grid">
            <table>
                <thead>
                <tr class="oculto">
                    <th class="centro">Id</th>
                    <th class="">Tipo</th>
                    <th class="">Data</th>
                    <th class="">Descrição</th>
                    <th class="">Documento</th>
                    <th class="">Contribuinte</th>
                    <th class="direita">Valor</th>
                    <th class="">Centro de Custo</th>
                    <th class="">Conta Bancária</th>
                    <th>Novo Plano Conta</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($lancamentos as $ret): ?>
                    <tr data-categoria="<?= hs($ret["categoria_financeira_id"]) ?>" class="oculto">
                        <td data-titulo="Id" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>
                        <td data-titulo="Tipo" class=""><?= e($tipo[$ret["tipo"]]) ?></td>
                        <td data-titulo="Data" class=""><?= e(bd\Formatos::dataApp($ret["data"])) ?></td>
                        <td data-titulo="Descrição" class=""><?= e($ret["descricao"]) ?></td>
                        <td data-titulo="Documento" class=""><?= e($ret["documento"]) ?></td>
                        <td data-titulo="Contribuinte" class=""><?= e($ret["contribuinte"]) ?></td>
                        <td data-titulo="Valor" class="direita"><?= e(bd\Formatos::moeda($ret["valor"])) ?></td>
                        <td data-titulo="Centro de Custo" class=""><?= e($ret["centro_custo"]) ?></td>
                        <td data-titulo="Conta Bancária" class="cortar"><?= e($ret["conta_financeira"]) ?></td>
                        <td class="acoes">
                            <div>
                                <?php if (Aut::temPermissao(Aut::$modulos['TRANSFERENCIA_PLANO_DE_CONTAS'], \modelo\Permissao::WRITE)) : ?>
                                    <select class="cat_filhas" data-movimentacao="<?= hs($ret["id"]) ?>">
                                        <option></option>
                                        <?php foreach ($categorias as $cat) : ?>
                                            <?php if ($cat['categoria_mae'] == $ret["categoria_financeira_id"]): ?>
                                                <option value="<?= hs($cat['id']) ?>"><?= hs($cat['num'] . ' - ' . $cat['nome']) ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="botoes">
            <a class="botao" onclick="salvar()">Salvar</a>
        </div>
    </div>

    <div id="j_salva" class="modal">
        <header>
            <h2>Transferindo...</h2>
            <a class="fechar" title="Fechar janela"></a>
        </header>
        <section>
            <h1>Transferir os lançamentos do Plano de Conta Mãe para as Filhas?</h1>
        </section>
        <div class="botoes">
            <a class="botao" id="btn_salvar" onclick="salva()">Confirmar</a>
            <a class="botao" onclick="modal.fecha()">Voltar</a>
        </div>
    </div>

<?php $template->fimMain() ?>
<?php $template->iniJs() ?>
    <script src="index.js"></script>
<?php $template->fimJs() ?>
<?php $template->renderiza() ?>