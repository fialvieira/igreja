<table>
    <thead>
        <tr>
            <!--<th class="centro">Id</th>-->
            <th class="">Nome</th>
            <!--<th class="">Cnpj</th>-->
            <th class="">Telefone</th>
            <th class="">Celular</th>
            <!--<th class="">Endereco</th>-->
            <!--<th class="">Numero</th>-->
            <!--<th class="">Complemento</th>-->
            <!--<th class="">Bairro</th>-->
            <th class="">Cidade</th>
            <th class="">UF</th>
            <!--<th class="">Email</th>-->
            <th class="">Pastor Titular</th>
            <th class="">Associação</th>
            <!--<th class="">Cliente</th>-->
<!--            <th class="">Matriz</th>-->
            <!--<th class="centro">Tipo</th>-->
            <th></th>
        </tr>
    </thead>
    <tbody> 
        <?php foreach ($retorno as $ret): ?>      
            <tr data-id="<?= hs($ret["id"]) ?>">
                <!--<td data-titulo="Id" class="centro"><?= e(\bd\Formatos::inteiro($ret["id"])) ?></td>-->
                <td data-titulo="Nome" class=""><?= e($ret["nome"]) ?></td>
                <!--<td data-titulo="Cnpj" class=""><?= e(\bd\Formatos::cnpjApp($ret["cnpj"])) ?></td>-->
                <td data-titulo="Telefone" class=""><?= e(\bd\Formatos::telefoneApp($ret["telefone"])) ?></td>
                <td data-titulo="Celular" class=""><?= e(\bd\Formatos::telefoneApp($ret["celular"])) ?></td>
<!--                <td data-titulo="Endereco" class=""><?= e($ret["logradouro"]) ?></td>
                <td data-titulo="Numero" class=""><?= e($ret["numero"]) ?></td>
                <td data-titulo="Complemento" class=""><?= e($ret["complemento"]) ?></td>
                <td data-titulo="Bairro" class=""><?= e($ret["bairro"]) ?></td>-->
                <td data-titulo="Cidade" class=""><?= e($ret["localidade"]) ?></td>
                <td data-titulo="UF" class=""><?= e($ret["uf"]) ?></td>
                <!--<td data-titulo="Email" class=""><?= e(\bd\Formatos::email($ret["email"])) ?></td>-->
                <td data-titulo="Pastor Titular" class=""><?= e($ret["pastor"]) ?></td>
                <td data-titulo="Associação" class=""><?= e($ret["associacao"]) ?></td>
                <!--<td data-titulo="Cliente" class=""><?= e($ret["cliente"]) ?></td>-->
                <!--<td data-titulo="Matriz" class=""><?= e($ret["matriz_id"]) ?></td>-->
                <!--<td data-titulo="Tipo" class="centro"><?= e(\bd\Formatos::inteiro($ret["tipo"])) ?></td>-->
                <td class="acoes" >
                    <div>
                        <?php if (!$permitido || ($ret['id'] != EMPRESA && $ret['cliente'] == 'S')): ?>    
                            <a id="a_acao" class="detalhe" title="Visualizar dados" href="empresa.php?id=<?= $ret["id"] ?>"></a>
                        <?php else: ?>    
                            <a id="a_acao" class="alterar" title="Alterar dados" href="empresa.php?id=<?= $ret["id"] ?>"></a>
                            <a class="<?= ($ret["ativo"] == "S") ? "ligado" : "desligado" ?>"
                               title="<?= ($ret["ativo"] == "S") ? "Desativar Igreja" : "Ativar Igreja" ?>"
                               onclick="liga_desliga(this)"></a>
                        <?php endif; ?>    
                    </div>
                </td>
            </tr>
        <?php endforeach; ?> 
    </tbody>
</table>