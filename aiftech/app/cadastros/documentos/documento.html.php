<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="documento.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>
    <div>
        <a onclick="voltar()">Documentos</a> / <?= (!$retorno->getId()) ? "Novo" : "Alterar" ?> 
    </div>
    <div id="info">
        <a class="info" href="../download_manual.php?dir=<?= $manual ?>" target="_blank" title="Visualizar Manual."></a>
    </div>
</h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="id" value="<?= e($retorno->getId()) ?>"> 
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
                        <label>Hora</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="hora" 
                               id="hora" 
                               maxlength="5"
                               placeholder="hh:mm"
                               <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>
                               value="<?= e($retorno->getHora()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo</label>
                    </div>
                    <div class="controle">
                        <select id="tipo" required <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
                            <option value=""></option>
                            <?php foreach ($tipos as $tipo) : ?>
                                <option <?= ($tipo["id"] == $retorno->getTipoDocumento()) ? 'selected' : '' ?>
                                    data-individual="<?= hs($tipo_individual[$tipo["id"]]) ?>"
                                    value="<?= e($tipo["id"]) ?>"><?= e($tipo["descricao"]) ?></option>
                                <?php endforeach; ?>
                        </select>
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Presidente / Pastor</label>
                    </div>
                    <div class="controle">
                        <select id="presidencia" required <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
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
                        <label>Membro(s)</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               id="membros" 
                               <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
                        <div class="mensagem"></div>
                        <div id="ctn_membros">
                            <?php foreach ($listaMembros as $membro): ?>
                                <div class="a_membro">
                                    <?php if ($retorno->getFinalizado() != 'S'): ?>
                                        <a class="acao excluir" title="Remover o membro." onclick="remove_membro(this)"></a>
                                    <?php endif; ?>
                                    <a data-id="<?= hs($membro['id']) ?>">
                                        <?= e($membro['nome']) ?>
                                    </a>
                                </div>  
                            <?php endforeach; ?>              
                        </div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Secretário(a)</label>
                    </div>
                    <div class="controle">
                        <select id="secretario" required <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
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
                        <label>Ata</label>
                    </div>
                    <div class="controle">
                        <select id="ata" <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
                            <option value=""></option>
                            <?php foreach ($atas as $ata) : ?>
                                <option value="<?= e($ata["id"]) ?>" 
                                        data-num="<?= e($ata["num"]) ?>"
                                        <?= ($ata["id"] == $retorno->getAtaId()) ? 'selected' : '' ?>><?= e($ata["num"] . ' - ' . $ata['tipo_desc']) ?></option>
                                    <?php endforeach; ?>
                        </select>
                        <!--<a href="downloadArquivo.php?dir=<?= hs($retorno->getPathArquivo()) ?>"><?= e($nome_arq) ?></a>-->
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Igreja Destino</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               id="igreja_destino" 
                                    <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?> 
                               data-value="<?= hs($retorno->getIgrejaDestinoId()) ?>"
                               value="<?= e($retorno->getIgrejaDestino())?>">
<!--                        <select id="igreja_destino" <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
                            <option value=""></option>
                        <?php // foreach ($igrejas as $igreja) : ?>
                                            <option value="<?= e($igreja["id"]) ?>" <?= ($igreja["id"] == $retorno->getIgrejaDestinoId()) ? 'selected' : '' ?>><?= e($igreja["nome"]) ?></option>
                        <?php // endforeach; ?>
                        </select>-->
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Pastor Destino</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               id="pastor_destino" 
                                    <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?> 
                               data-value="<?= hs($retorno->getPastorDestinoId()) ?>"
                               value="<?= e($retorno->getPastorDestino())?>">
<!--                        <select id="pastor_destino" <?/*= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' */ ?>>
                            <option value=""></option>
                            <?php // foreach ($pastores as $pastor) : ?>
                                <option value="<?= e($pastor["id"]) ?>" <?= ($pastor["id"] == $retorno->getPastorDestinoId()) ? 'selected' : '' ?>><?= e($pastor["nome"]) ?></option>
                            <?php // endforeach; ?>
                        </select>-->
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Data Carta Recebida</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="data" 
                               id="data_carta" 
                               <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>
                               value="<?= e($retorno->getDataCarta()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <!--                <div class="campo">
                                    <div class="rotulo">
                                        <label>Extensão Arquivo Gerar</label>
                                    </div>
                                    <div class="controle">
                                        <select id="extensao" required <?= ($retorno->getFinalizado() == 'S') ? 'disabled' : '' ?>>
                                            <option value=""></option>
                <?php foreach ($extensoes as $k => $v) : ?>
                                                                    <option value="<?= $k ?>" <?= ($k == $retorno->getExtensao()) ? 'selected' : '' ?>>
                    <?= e($v) ?>
                                                                    </option>
                <?php endforeach; ?>
                                        </select>
                                        <div class="mensagem"></div>
                                    </div>
                                </div>-->
                <div class="campo">
                    <div class="rotulo">
                        <label id="rotulo_texto">Anexar Documento</label>
                    </div>
                    <div class="controle arquivo">
                        <label class="file rotulo_arq <?= ($nome_arq) ? 'oculto' : '' ?>" for="arquivo" title="Upload do documento digitalizado."></label>
                        <input type="file" id="arquivo" onchange="seleciona_arquivo(this)">
                        <?php if (!$nome_arq): ?>
                            <div class="mensagem"></div>
                            <div id="ctn_doc"></div>
                        <?php else: ?>
                            <div class="mensagem"></div>
                            <div id="ctn_doc">
                                <div class="a_arquivo">
                                    <?php if ($retorno->getFinalizado() != 'S'): ?>
                                        <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>
                                    <?php endif; ?>
                                    <a data-path="<?= hs($retorno->getPathArquivo()) ?>"
                                       href="downloadArquivo.php?dir=<?= hs($retorno->getPathArquivo()) ?>">
                                           <?= e($nome_arq) ?>
                                    </a>
                                </div>  
                            </div>            
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="botoes">
                <?php if ($retorno->getFinalizado() != 'S'): ?>
                    <a class="botao" id="salvar" onclick="salva()">Salvar</a>
                    <?php if ($retorno->getId() && $nome_arq && $eh_presidente): ?>
                        <a class="botao" onclick="finalizar()">Finalizar</a>
                    <?php endif; ?>
                    <?php // if ($retorno->getId()): ?>
                    <a class="botao <?= ($retorno->getId()) ? '' : 'oculto' ?>" id="imprimir" onclick="imprime();">Imprimir</a>
                    <!--<a class="botao" href="imprime.php?id=<?= hs($retorno->getId()) ?>" target="_blank">Imprimir</a>-->
                    <?php // endif; ?>
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
                    <tr>
                        <td data-id="<?= hs($membro[0]["id"]) ?>"><?= e($membro[0]["nome"]) ?></td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
        </table>      
    </div>
</div>

<!--Janela com lista das igrejas-->
<div id="j_igrejas" class="combo flutuante">
    <div>
        <table>
            <tbody> 
                <?php foreach ($igrejas as $igreja) : ?>
                    <tr>
                        <td data-value="<?= hs($igreja["id"]) ?>"><?= e($igreja["nome"]) ?></td>
                    </tr>
            <?php endforeach; ?>
            </tbody>
        </table>      
    </div>
</div>

<!--Janela com lista dos pastores-->
<div id="j_pastores" class="combo flutuante">
    <div>
        <table>
            <tbody> 
                <?php foreach ($pastores as $pastor) : ?>
                    <tr>
                        <td data-value="<?= hs($pastor["id"]) ?>"><?= e($pastor["nome"]) ?></td>
                    </tr>
            <?php endforeach; ?>
            </tbody>
        </table>      
    </div>
</div>

<!--Janela finalizar documento-->
<div id="j_finalizar" class="modal">
    <header>
        <h2>Finalizar</h2>
        <a class="fechar" title="Fechar janela"></a>
    </header>
    <section>
        Deseja Finalizar o Documento? Após finalização não será possível alteração das informações do mesmo.
    </section>
    <div class="botoes">
        <a class="botao" onclick="finaliza()">Confirmar</a>
        <a class="botao" onclick="modal.fecha()">Voltar</a>
    </div>
</div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script type="text/javascript">
    //    window.sessionStorage.setItem('igreja', '<?/*= $empresa->getNome() */?>');
    //    window.sessionStorage.setItem('endereco', '<?/*= $tx_endereco */ ?>');
</script>
<script src="documento.js"></script>

<?php $template->fimJs() ?>

<?php $template->renderiza() ?>