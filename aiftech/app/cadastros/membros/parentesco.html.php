<?php $template = new \templates\Igreja() ?>
<?php $template->iniCss() ?>
    <link rel="stylesheet" href="parentesco.css">
<?php $template->fimCss() ?>
<?php $template->iniMain() ?>
    <h1>
        <div>
            <a onclick="voltar()">Membros</a> / Relação de Parentesco
        </div>
        <div id="info">
            <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank"
               title="Visualizar Manual."></a>
        </div>
    </h1>

    <div class="container">
        <div>
            <div class="card">
                <h1>Relação de Parentesco</h1>
                <div class="campos">
                    <input type="hidden" id="tabela" value="membros">
                    <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>">
                    <div class="campo">
                        <div class="rotulo">
                            <label><?= e($retorno->getNome()) ?> é</label>
                        </div>
                        <div class="controle">
                            <select id="tipo_relacionamento" required>
                                <option value=""></option>
                                <?php foreach ($tipos_parentesco as $k => $v): ?>
                                    <option value="<?= e($v['id']) ?>"><?= e($v['descricao']) ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input type="text"
                                   id="participantes"
                                   placeholder="Digite o nome para pesquisar"
                                   onkeyup="filtra(event)"
                                   required>
                            <a class="acao incluir" title="Incluir familiar" onclick="salvaRelacionamento()"></a>
                            <div id="ctn_parentesco">
                                <?php if (!empty($parentesco)): ?>
                                    <?php foreach ($parentesco as $k => $v): ?>
                                        <div class="a_parentesco">
                                            <a data-id="<?= e($v['id']) ?>"
                                               data-tipo_relacionamento_id="<?= e($v['tipo_relacionamento_id']) ?>"
                                               data-parente_id="<?= e($v['membro2_id']) ?>"
                                               data-parente_base_id="<?= e($v['membro_id']) ?>"
                                               class="acao excluir"
                                               title="Excluir parentesco"
                                               onclick="remove(this)"></a>
                                            <label><?= e($v['descricao']) ?> de <?= e($v['nome_dois']) ?></label>&nbsp;
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="mensagem"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="botoes">
        <a class="botao" onclick="voltar()">Voltar</a>
    </div>

    <!--Janela com lista dos membros-->
    <div id="j_membros" class="combo">
        <div id="detalhes_grid">
            <table>
                <tbody>
                <?php foreach ($membros as $membro) : ?>
                    <tr data-id="<?= hs($membro["id"]) ?>" data-nome="<?= e($membro["nome"]) ?>"
                        onclick="adicionaParenteCampo(this)">
                        <td><?= e($membro["nome"]) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
    <script src="parentesco.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>