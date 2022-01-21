<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="ata.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>
    <div>
        <a onclick="voltar()">Atas</a> / <?= (!$retorno->getId()) ? "Novo" : "Alterar" ?> 
    </div>
    <div id="info">
        <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank" title="Visualizar Manual."></a>
    </div>
</h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="id" value="<?= e(\bd\Formatos::inteiro($retorno->getId())) ?>"> 
                <div class="campo">
                    <div class="rotulo">
                        <label>Número</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="num" 
                               disabled
                               value="<?= e($retorno->getNum()) ?>">
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
                               maxlength="10"
                               required
                               <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>
                               value="<?= e(\bd\Formatos::dataApp($retorno->getData())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo</label>
                    </div>
                    <div class="controle">
                        <select id="tipo" required onchange="ao_mudar_tipo(this)" <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
                            <option value=""></option>
                            <?php foreach ($tipos as $tipo) : ?>
                                <option data-padrao="<?= $tipo["texto_padrao"] ?>" <?= ($tipo["id"] == $retorno->getTipoAta()) ? 'selected' : '' ?>
                                        value="<?= e($tipo["id"]) ?>"><?= e($tipo["descricao"]) ?></option>
                                    <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Presidente Ata</label>
                    </div>
                    <div class="controle">
                        <select id="presidencia" required onchange="ao_mudar_presidente(this)" <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
                            <option value=""></option>
                            <?php foreach ($presidente as $p) : ?>
                                <option value="<?= e($p["id"]) ?>" <?= ($p["id"] == $retorno->getPresidencia()) ? 'selected' : '' ?>><?= e($p["nome"]) ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Participantes</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               id="participantes" 
                               <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Texto</label>
                    </div>
                    <div class="controle">
                        <textarea id="tx_corpo" onblur="setUltimoCampoTx(this);" <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>><?= e($retorno->getTxCorpo()) ?></textarea>
                        <div class="mensagem"></div>
                    </div>
                </div>        
                <div class="campo">
                    <div class="rotulo">
                        <label>Secretário(a) Ata</label>
                    </div>
                    <div class="controle">
                        <select id="secretario" required onchange="ao_mudar_secretaria(this)" <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
                            <option value=""></option>
                            <?php foreach ($secretario as $s) : ?>
                                <option value="<?= e($s["id"]) ?>" <?= ($s["id"] == $retorno->getSecretario()) ? 'selected' : '' ?>
                                        style="<?= ($s['ordem'] == '1') ? 'color:red' : '' ?>"><?= e($s["nome"]) ?></option>
                                    <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label id="rotulo_texto">Anexar Ata (PDF)</label>
                    </div>
                    <div class="controle arquivo">
                        <?php if (!$ata) : ?>
                            <label class="file rotulo_arq" for="arquivo_ata" title="Upload da Ata Digitalizada."></label>
                            <input type="file" id="arquivo_ata" name="arquivo" onchange="seleciona_arquivo(this)">
                            <div class="mensagem"></div>
                            <div id="ctn_ata"></div>
                        <?php else: ?>
                            <div class="mensagem"></div>
                            <div id="ctn_ata">
                                <?php // foreach ($ata as $a): ?>
                                <div class="a_arquivo">
                                    <?php if ($retorno->getFinalizado() != 'S'): ?>
                                        <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>
                                    <?php endif; ?>
                                    <a data-id="<?= hs($ata['id']) ?>"
                                       data-path="<?= hs($ata['path']) ?>"
                                       href="downloadArquivo.php?dir=<?= hs($ata['path']) ?>" 
                                       target="_blank" 
                                       title="Visualizar Ata Digitalizada.">
                                           <?= e($ata['nome']) ?>
                                    </a>
                                </div>  
                                <?php // endforeach; ?>              
                            </div>            
                        <?php endif; ?>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label id="rotulo_texto">Anexar Arquivos</label>
                    </div>
                    <div class="controle arquivo">
                        <?php if ($retorno->getFinalizado() != 'S'): ?>
                            <label class="file rotulo_arq" for="arquivo" title="Upload de arquivo."></label>
                            <input type="file" id="arquivo" name="arquivo" onchange="seleciona_arquivo(this)" multiple>
                        <?php endif; ?>
                        <div class="mensagem"></div>
                        <div id="ctn_arquivos">
                            <?php foreach ($arquivos as $arquivo): ?>
                                <div class="a_arquivo">
                                    <?php if ($retorno->getFinalizado() != 'S'): ?>
                                        <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>
                                    <?php endif; ?>
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
            <div class="legenda">
                <span>Para texto em <b>Negrito</b> digitar <b>(b)</b> antes da palavra/frase e <b>(/b)</b> para terminar. </span>
                <span>Para texto <u>Sublinhado</u> digitar <u>(u)</u> antes da palavra/frase e <u>(/u)</u> para terminar. </span>        
            </div>
            <div class="botoes">
                <?php if ($retorno->getId() && $retorno->getFinalizado() != 'S' && $eh_presidente): ?>
                    <a class="botao" onclick="finalizar()">Finalizar</a>
                <?php endif; ?>
                <?php if (!$ata || $retorno->getFinalizado() != 'S'): ?>
                    <a class="botao" id="salvar" onclick="salva()">Salvar</a>
                    <?php if ($retorno->getId()): ?>
                        <a class="botao" href="imprime.php?id=<?= hs($retorno->getId()) ?>" target="_blank">Imprimir</a>
                    <?php endif; ?>
                <?php endif; ?>
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
                    <tr data-array='<?= json_encode($membro) ?>'>
                        <td class="" data-value="<?= hs($membro[0]["codigo"]) ?>"><?= e($membro[0]["nome"]) ?></td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
        </table>      
    </div>
</div>

<!--Janela finalizar ata-->
<div id="j_finalizar" class="modal">
    <header>
        <h2>Finalizar</h2>
        <a class="fechar" title="Fechar janela"></a>
    </header>
    <section>
        Deseja Finalizar a Ata? Após finalização não será possível alteração das informações da mesma, poderá apenas inserir a Ata assinada e digitalizada.
    </section>
    <div class="botoes">
        <a class="botao" onclick="finaliza()">Confirmar</a>
        <a class="botao" onclick="modal.fecha()">Voltar</a>
    </div>
</div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script type="text/javascript">
    window.sessionStorage.setItem('igreja', '<?= $empresa->getNome() ?>');
    window.sessionStorage.setItem('endereco', '<?= $tx_endereco ?>');
</script>
<script src="ata.js"></script>

<?php $template->fimJs() ?>

<?php $template->renderiza() ?>