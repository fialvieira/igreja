<?php $template = new \templates\Igreja() ?>

<?php $template->iniCss() ?>
<link rel="stylesheet" href="church.css">
<?php $template->fimCss() ?>

<?php $template->iniMain() ?>

<!--<h1><a href="ndex.php">Igrejas</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>-->
<h1><a onclick="voltar()">Igrejas</a> / <?=(!$filtro[0]) ? "Novo" : "Alterar"?> </h1>
<div class="container">
    <div>
        <div class="card">
            <div class="campos">
                <input type="hidden" id="tabela" value="churchs">
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
                               maxlength="150"
                               value="<?= e($retorno->getNome()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Cnpj</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="cnpj" 
                               id="cnpj" 
                               
                               required
                               maxlength="14"
                               value="<?= e(\bd\Formatos::cnpjApp($retorno->getCnpj())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Telefone</label>
                    </div>
                    <div class="controle">
                        <input type="tel" 
                               class="telefone" 
                               id="telefone" 
                               
                               required
                               maxlength="15"
                               value="<?= e(\bd\Formatos::telefoneApp($retorno->getTelefone())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Endereco</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="endereco" 
                               
                               
                               maxlength="150"
                               value="<?= e($retorno->getEndereco()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Numero</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="numero" 
                               
                               
                               maxlength="5"
                               value="<?= e($retorno->getNumero()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Complemento</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="complemento" 
                               
                               
                               maxlength="50"
                               value="<?= e($retorno->getComplemento()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Bairro</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="bairro" 
                               
                               
                               maxlength="45"
                               value="<?= e($retorno->getBairro()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Cidade</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="cidade" 
                               
                               
                               maxlength="45"
                               value="<?= e($retorno->getCidade()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>UF</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="uf" 
                               
                               
                               maxlength="2"
                               value="<?= e($retorno->getUf()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Email</label>
                    </div>
                    <div class="controle">
                        <input type="email" 
                               class="email" 
                               id="email" 
                               
                               
                               maxlength="150"
                               value="<?= e(\bd\Formatos::email($retorno->getEmail())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Matriz</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="texto" 
                               id="matriz_id" 
                               
                               
                               maxlength="5"
                               value="<?= e($retorno->getMatrizId()) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                <div class="campo">
                    <div class="rotulo">
                        <label>Tipo</label>
                    </div>
                    <div class="controle">
                        <input type="text" 
                               class="inteiro" 
                               id="tipo" 
                               
                               
                               maxlength="11"
                               value="<?= e(\bd\Formatos::inteiro($retorno->getTipo())) ?>">
                        <div class="mensagem"></div>
                    </div>
                </div>
                        <input type="hidden" id="subdomain" value="<?= e($retorno->getSubdomain()) ?>"> 
            </div>
            <div class="botoes">
                <a class="botao" onclick="salva()">Salvar</a>
                <a class="botao" onclick="voltar()">Voltar</a>
            </div>
        </div>
    </div>
</div>

    <?php $template->fimMain() ?>

    <?php $template->iniJs() ?>
    <script src="church.js"></script>
    <?php $template->fimJs() ?>

    <?php $template->renderiza() ?>