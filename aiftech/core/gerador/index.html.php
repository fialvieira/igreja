<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="index.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>Gerador Telas</h1>
<div class="container">
    <div>
        <div class="card">
            <h2>Seleciona as tabelas para gerar tela de cadastros automaticamente</h2>
            <div class="campos">
                <div class="campo ">
                    <div class="rotulo">
                        <label>Tabelas</label>
                    </div>
                    <div class="controle">
                        <div class="grid" id="tabelas">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th><a onclick="seleciona_todas();">Seleciona</a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tabelas as $tabela): ?>
                                        <?php $existe = ''; ?>
                                        <?php if ($tabela['EXIST']): ?>
                                        <?php $existe = 'vermelho'; ?>
                                        <?php endif; ?>        
                                        <tr class="<?= $existe ?>">
                                            <td data-titulo="Nome" ><?= e($tabela['TABLE_NAME']) ?></td> 
                                            <td data-titulo="Seleciona" class="acoes" title="Seleciona item">
                                                <div>
                                                    <a class="seleciona"
                                                       onclick="seleciona_tabela(this);"
                                                       data-tabela="<?= hs($tabela['TABLE_NAME']) ?>"
                                                       data-descricao="<?= hs($tabela['TABLE_COMMENT']) ?>"></a>
                                                </div>
                                            </td>   
                                        </tr>
                                    <?php endforeach; ?>      
                                </tbody>
                            </table>
                        </div>
                        <div class="mensagem"></div>
                    </div>
                </div>
            </div>
            <div class="botoes">
                <a class="botao" onclick="gerar()">Gerar Telas</a>
            </div>
        </div>
    </div>
</div>
<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script src="index.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>