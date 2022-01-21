<?php $template = new \templates\Igreja()?>

<?php $template->iniCss()?>
<link rel="stylesheet" href="escolaridade.css">
<?php $template->fimCss()?>

<?php $template->iniMain()?>

<!--<h1><a href="ndex.php">Escolaridades</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>-->
<h1><a onclick="voltar()">Escolaridades</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="escolaridades">
                <input type="hidden" id="id" value="<?=e(\bd\Formatos::inteiro($retorno->getId()))?>"> 
                <div class="campo">
                    <div class="rotulo">
                        <label>Descrição</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="descricao" 

                               required
                               maxlength="100"
                               value="<?=e($retorno->getDescricao())?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Observação</label>
                    </div>
                    <div class="controle">
                        <textarea class="memo" 
                                  id="obs" 

                                  maxlength="65535"><?=e($retorno->getObs())?></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <input type="hidden" id="created" value="<?=e(\bd\Formatos::dataHoraApp($retorno->getCreated()))?>"> 
                <input type="hidden" id="modified" value="<?=e(\bd\Formatos::dataHoraApp($retorno->getModified()))?>"> 
                <input type="hidden" id="user_id" value="<?=e(\bd\Formatos::inteiro($retorno->getUserId()))?>"> 
            </div>
            <div class="botoes">
                <a class="botao" onclick="salva()">Salvar</a>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
</div>

<?php $template->fimMain()?>

<?php $template->iniJs()?>
<script src="escolaridade.js"></script>
<?php $template->fimJs()?>

<?php $template->renderiza()?>