<table>
    <thead>
    <tr>
        <?php if ($id != '' && !is_null($id) && !is_null($foto)): ?>
            <th></th>
        <?php endif; ?>
        <th class="coluna_nome">Nome</th>
        <th class="">Data Nascimento</th>
        <th class="coluna_sexo">Sexo</th>
        <th class="coluna_naturalidade">Naturalidade</th>
        <th class="coluna_estado">Estado</th>
        <th class="coluna_rg">RG</th>
        <th class="coluna_escolaridade">Escolaridade</th>
        <th class="coluna_profissao">Profissão</th>
        <th class="coluna_empresa">Empresa</th>
        <th>Estado Civil</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php if ($id != '' && !is_null($id) && !is_null($foto)): ?>
            <td class="det_foto"><img class="imagem" src="<?= SITE . ($foto) ?>"></td>
        <?php endif; ?>
        <td data-titulo="Nome" class="coluna_nome"><?= e($retorno->getNome()) ?></td>
        <td data-titulo="Data Nascimento" class=""><?= e($retorno->getDatanascimento()) ?></td>
        <td data-titulo="Sexo"
            class="coluna_sexo"><?= e((!is_null($retorno->getSexo())) ? (($retorno->getSexo() == 'M') ? 'Masculino' : 'Feminino') : '' ) ?></td>
        <td data-titulo="Naturalidade" class="coluna_naturalidade"><?= e($retorno->getNaturalidade()) ?></td>
        <td data-titulo="Estado" class="coluna_estado"><?= e($estado->getSigla()) ?></td>
        <td data-titulo="RG" class="coluna_rg"><?= e($retorno->getRg()) ?></td>
        <td data-titulo="Escolaridade" class="coluna_escolaridade"><?= e($escolaridade->getDescricao()) ?></td>
        <td data-titulo="Profissão" class=""><?= e($profissao->getNome()) ?></td>
        <td data-titulo="Empresa" class=""><?= e($retorno->getEmpresa()) ?></td>
        <td data-titulo="Estado Civil"><?= e((!is_null($retorno->getEstadoCivil()) && $retorno->getEstadoCivil() !== "") ? \modelo\Membro::ESTADO_CIVIL[$retorno->getEstadoCivil()] : '') ?></td>
    </tr>
    </tbody>
</table>
<br>
<table>
    <thead>
    <tr>
        <th class="coluna_dt_batismo">Data Batismo</th>
        <th class="coluna_igreja_batismo">Igreja Batismo</th>
        <th class="coluna_pastor_batismo">Pastor Batismo</th>
        <th class="">Data Membresia</th>
        <th class="">Ultima Igreja</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td data-titulo="Data Batismo"
            class=""><?= e((!is_null($retorno->getDatabatismo()) && $retorno->getDatabatismo() != "") ? \bd\Formatos::dataApp($retorno->getDatabatismo()) : '') ?></td>
        <td data-titulo="Igreja Batismo" class=""><?= e($igreja_batismo->getNome()) ?></td>
        <td data-titulo="Pastor Batismo" class=""><?= e($pastor_batismo->getNome()) ?></td>
        <td data-titulo="Data Membresia" class=""><?= e($retorno->getDatamembro()) ?></td>
        <td data-titulo="Ultima Igreja" class=""><?= e($ultima_igreja->getNome()) ?></td>
    </tr>
    </tbody>
</table>
<?php if ($flag_ig_ant): ?>
    <br>
    <table>
        <thead>
        <tr>
            <th class="">Igrejas Anteriores</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td data-titulo="Igrejas Anteriores" class=""><?= e($ig) ?></td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>
<?php if ($flag_dom): ?>
    <br>
    <table>
        <thead>
        <tr>
            <th class="coluna_dons">Dons</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td data-titulo="Dons"><?= e($dom) ?></td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>
<?php if ($flag_deps): ?>
    <br>
    <table>
        <thead>
        <tr>
            <th>Ministérios Interesse</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td data-titulo="Ministérios Interesse"><?= e($di) ?></td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>
<?php if (!empty($cargos_ocupados)): ?>
    <br>
    <table>
        <thead>
        <tr>
            <th class="">Período</th>
            <th>Cargo</th>
            <th>Departamento</th>
            <th>Ativo</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cargos_ocupados as $k => $v): ?>
            <tr>
                <td data-titulo="Período" class=""><?= e($v["periodo"]) ?></td>
                <td data-titulo="Cargo"><?= e($v["cargo"]) ?></td>
                <td data-titulo="Departamento"><?= e($v["departamento"]) ?></td>
                <td data-titulo="Ativo"><?= e(($v["ativo"] == 'S') ? 'Sim' : 'Não') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php if ($flag_parentesco): ?>
    <br>
    <table>
        <thead>
        <tr>
            <th>Tipo</th>
            <th>Nome</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($parentesco as $k => $v): ?>
            <tr>
                <td data-titulo="Tipo"><?= e($v["descricao"]) ?></td>
                <td data-titulo="Nome"><?= e($v["nome_dois"]) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>