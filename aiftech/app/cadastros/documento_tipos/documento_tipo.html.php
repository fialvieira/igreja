<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="documento_tipo.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<h1>
    <div>
        <a onclick="voltar()">Tipo de Documentos</a> / <?= (!$retorno->getId()) ? "Novo" : "Alterar" ?> 
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
                        <label>Descrição</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="descricao" 
                               required
                               maxlength="50"
                               value="<?= e($retorno->getDescricao()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label id="rotulo_texto">Anexar Modelo (Word)</label>
                    </div>
                    <div class="controle arquivo">
                        <label class="file rotulo_arq <?= ($nome_arq) ? 'oculto' : '' ?>" for="arquivo" title="Extensão do arquivo deve ser .docx"></label>
                        <input type="file" id="arquivo" onchange="seleciona_arquivo(this)">
                        <?php if (!$nome_arq): ?>
                            <div class="mensagem"></div>
                            <div id="ctn_doc"></div>
                        <?php else: ?>
                            <div class="mensagem"></div>
                            <div id="ctn_doc">
                                <div class="a_arquivo">
                                    <a class="acao excluir" title="Remover o Arquivo." onclick="remove_arquivo(this)"></a>
                                    <a data-path="<?= hs($retorno->getPathModelo()) ?>"
                                       href="downloadArquivo.php?dir=<?= hs($retorno->getPathModelo()) ?>" 
                                       target="_blank" 
                                       title="Visualizar Modelo.">
                                           <?= e($nome_arq) ?>
                                    </a>
                                </div>  
                            </div>            
                        <?php endif; ?>
                    </div>
                </div>
            </div>
          <div class="legenda">
            <b><u>Legenda</u></b>
                <span><b>${numeroDocumento} - </b>Mostra o número do documento. </span>
                <span><b>${nomePastor} - </b>Mostra o nome do Presidente ou pastor que assinará a carta. </span>
                <span><b>${cargoPastor} - </b>Mostra o cargo do responsável por assinar a carta, presidente ou pastor. </span>
                <span><b>${rgPastor} - </b>Mostra o RG do pastor titular da igreja emissora da carta. </span>
                <span><b>${cpfPastor} - </b>Mostra o CPF do pastor titular da igreja emissora da carta. </span>
                <span><b>${data} - </b>Mostra a data da carta. </span>
                <span><b>${dataExtenso} - </b>Mostra a data da carta por extenso, incluindo dia e ano. </span>
                <span><b>${dataMesExtenso} - </b>Mostra a data da carta apenas com o mês por extenso. </span>
                <span><b>${horaExtenso} - </b>Mostra a hora  da carta, quando preenchido, por extenso. </span>
                <span><b>${nomeIgreja} - </b>Mostra o nome da igreja emissora da carta. </span>
                <span><b>${nomeIgrejaUpper} - </b>Mostra o nome da igreja emissora da carta em caixa alta (CAPSLOCK). </span>
                <span><b>${cnpjIgreja} - </b>Mostra o CNPJ da igreja emissora da carta. </span>
                <span><b>${enderecoIgreja} - </b>Mostra o endereço completo da igreja emissora da carta. </span>
                <span><b>${cidadeIgreja} - </b>Mostra a cidade da igreja emissora da carta. </span>
                <span><b>${estadoIgreja} - </b>Mostra a UF da igreja emissora da carta. </span>
                <span><b>${cidadeUfIgreja} - </b>Mostra a cidade e UF da igreja emissora da carta. </span>
                <span><b>${nomePresidente} - </b>Mostra o nome do presidente em exercício da igreja emissora da carta. </span>
                <span><b>${rgPresidente} - </b>Mostra o RG do presidente em exercício da igreja emissora da carta. </span>
                <span><b>${cpfPresidente} - </b>Mostra o CPF do presidente em exercício da igreja emissora da carta. </span>
                <span><b>${nomeMembro} - </b>Mostra o nome do membro informado na carta. </span>
                <span><b>${nomeMembroUpper} - </b>Mostra o nome do membro informado na carta em caixa alta (CAPSLOCK). </span>
                <span><b>${rgMembro} - </b>Mostra o RG do membro informado na carta. </span>
                <span><b>${cpfMembro} - </b>Mostra o CPF do membro informado na carta. </span>
                <span><b>${enderecoMembro} - </b>Mostra o endereço completo do membro informado na carta. </span>
                <span><b>${cidadeUfMembro} - </b>Mostra a cidade e UF do membro informado na carta. </span>
                <span><b>${CEPMembro} - </b>Mostra o CEP do membro informado na carta. </span>
                <span><b>${dataAta} - </b>Mostra a data da ata informado na carta, quando preenchido. </span>
                <span><b>${dataAtaExtenso} - </b>Mostra a data da ata por extenso, incluindo dia e ano, quando informado na carta. </span>
                <span><b>${nomeSecretario} - </b>Mostra o nome do secretário que assinara a carta. </span>
                <span><b>${cargoSecretario} - </b>Mostra o cargo do secretário que assinara a carta. </span>
                <span><b>${nomeIgrejaDestino} - </b>Mostra o nome da igreja de destino da carta, quando preenchido. </span>
                <span><b>${enderecoIgrejaDestino} - </b>Mostra o endereço completo da igreja de destino da carta, quando preenchido. </span>
                <span><b>${cidadeUfIgrejaDestino} - </b>Mostra a cidade e UF da igreja de destino da carta, quando preenchido. </span>
                <span><b>${CEPIgrejaDestino} - </b>Mostra o CEP da igreja de destino da carta, quando preenchido. </span>
                <span><b>${pastorIgrejaDestino} - </b>Mostra o nome do pastor titular da igreja de destino da carta, quando preenchido. </span>
                <span><b>${nomeDestinatario} - </b>Mostra o nome do membro informado no documento. </span>
                <span><b>${enderecoDest} - </b>Mostra o endereço completo do membro informado no documento. </span>
                <span><b>${cidadeUfDest} - </b>Mostra a cidade e UF do membro informado no documento. </span>
                <span><b>${CEPDest} - </b>Mostra o CEP do membro informado no documento. </span>
                <span><b>${dataCartaRecebida} - </b>Mostra a data da carta recebida de outra igreja, quando preenchido. </span>
                <span><b>${listaNomesMembros} - </b>Mostra os nomes de membros informados na carta. </span>
            </div>          
            <div class="botoes">
                <a class="botao" id="salvar" onclick="salva()">Salvar</a>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
</div>

<?php $template->fimMain() ?>

<?php $template->iniJs() ?>
<script src="documento_tipo.js"></script>
<?php $template->fimJs() ?>

<?php $template->renderiza() ?>