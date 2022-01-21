<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" type="image/png" sizes="64x64" href="<?= SITE ?>core/templates/igreja/img/favico.ico">
    <title><?= \Sistema::$nome ?></title>
    <link rel="stylesheet" href="quorum_assembleias.css">
</head>
<body>
<htmlpageheader name="MyHeader1">
    <table class="header">
        <tr>
            <td width="1%"><img src="<?= RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/img/logo.png' ?>" height="80"
                                width="50"></td>
            <td width="99%">
                <?= e($empresa->getNome()) ?> - <?= e($estado->getSigla()) ?><br>
                <span class="menor">Quórum de Membros para Assembléias</span>
            </td>
        </tr>
    </table>
</htmlpageheader>

<htmlpagefooter name="MyFooter1">
    <table width="100%">
        <tr>
            <td colspan="3">Obs: Aqui são contados todos os membros com data de nascimento cadastrado, caso não haja
                cadastro, o membro não
                comporá quórum.
            </td>
        </tr>
        <tr>
            <td width="33%"><span style="font-weight: bold; font-style: italic;">{DATE j-m-Y}</span></td>
            <td width="33%" align="center" style="font-weight: bold; font-style: italic;">{PAGENO}/{nbpg}</td>
            <td width="33%" style="text-align: right; "><?= e($empresa->getNome()) ?></td>
        </tr>
    </table>
</htmlpagefooter>

<sethtmlpageheader name="MyHeader1" value="on" show-this-page="1"/>
<sethtmlpagefooter name="MyFooter1" value="on"/>

<section class="corpo">
    <!--<div class="subtitulo">Quórum de Membros para Assembléias</div>-->
    <div class="tabela">
        <table>
            <thead>
            <tr>
                <th>SEDE</th>
                <th class="numero">Total Geral <?= e($rel_membros->membrosTotalGeral('A')) ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0 ?>
            <?php foreach ($quorum_sede as $k => $v):
                $i += $v['TOTAL'];
                ?>
                <tr>
                    <td>
                        <?= e($v['frequencia']) ?>
                    </td>
                    <td class="numero">
                        <?= e($v['TOTAL']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="negrito">Total</td>
                <td class="numero negrito"><?= e($i) ?></td>
            </tr>
            <?php
            $tot_quorum = $i;
            $i = 0;
            ?>
            <?php foreach ($nao_quorum_sede as $k => $v):
                $i += $v['TOTAL'];
                ?>
                <tr>
                    <td>
                        <?= e($v['frequencia']) ?>
                    </td>
                    <td class="numero">
                        <?= e($v['TOTAL']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="negrito">Total</td>
                <td class="numero negrito"><?= e($i) ?></td>
            </tr>
            <?php
            $tot_n_quorum = $i;
            $i = 0;
            $id_anterior = null;
            ?>
            </tbody>
        </table>
        <?php foreach ($quorumNaoSede as $k => $v): ?>
            <table>
                <?php if ($v['id'] !== $id_anterior): ?>
                    <thead>
                    <tr>
                        <th colspan="2"><?= e($v['nome']) ?></th>
                    </tr>
                    </thead>
                <?php endif; ?>
                <tbody>
                <?php foreach ($rel_membros->quorumNaoSedeDetalhado($v['id'], $v['quorum']) as $key => $value):
                    $i += $v['TOTAL'];
                    ?>
                    <tr>
                        <td>
                            <?= e($value['frequencia']) ?>
                        </td>
                        <td class="numero">
                            <?= e($value['TOTAL']) ?>
                        </td>
                    </tr>
                    <?php
                    if ($v['quorum'] === 'S') {
                        $tot_quorum += $i;
                    } else {
                        $tot_n_quorum += $i;
                    }
                    ?>
                <?php endforeach; ?>
                <tr>
                    <td class="negrito">Total</td>
                    <td class="numero negrito"><?= e($v['TOTAL']) ?></td>
                </tr>
                <?php
                $i = 0;
                $id_anterior = $v['id'];
                ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    </div>
    <pagebreak page-break-type="slice">
</section>
<section class="corpo novo">
    <div class="tabela">
        <table>
            <thead>
            <tr>
                <th>Composição do Quórum</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="negrito">(A) = Todos os Membros</td>
                <td class="numero"><?= e($rel_membros->membrosTotalGeral('A')) ?></td>
            </tr>
            <tr>
                <td>( - ) Membros de Congregações; não conta para quórum</td>
                <td class="numero"><?= e($tot_n_quorum) ?></td>
            </tr>
            <tr>
                <td class="negrito">(B) = Membros para cálculo do Quórum</td>
                <td class="numero"><?= e($tot_quorum) ?></td>
            </tr>
            </tbody>
        </table>
        <table>
            <thead>
            <tr>
                <th>Quórum - Assembléia Ordinária</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="negrito">(B) = Membros para cálculo do Quórum</td>
                <td class="numero"><?= e($tot_quorum) ?></td>
            </tr>
            <tr>
                <td>= Quórum da 1ª convocação (1 / 3 membros presentes) = (B / 3)</td>
                <td class="numero"><?= e(round($tot_quorum / 3)) ?></td>
            </tr>
            <tr>
                <td class="negrito">= Quórum da 2ª convocação = (Membros presentes)</td>
                <td class="numero"><?= e('Membros presentes') ?></td>
            </tr>
            <tr>
                <td>Obs: Inclui todos os membros.</td>
            </tr>
            </tbody>
        </table>

        <table>
            <thead>
            <tr>
                <th>Quórum - Assembléia Extraordinária</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="negrito">(B) = Membros para cálculo do Quórum</td>
                <td class="numero"><?= e($tot_quorum) ?></td>
            </tr>
            <tr>
                <td>( - ) Membros menores de 18 anos</td>
                <td class="numero"><?= e($total_menores) ?></td>
            </tr>

            <tr>
                <td class="negrito">(C) = (B) Membros para cálculo do Quórum ( - ) Menores</td>
                <td class="numero"><?= e($tot_quorum - $total_menores) ?></td>
            </tr>

            <tr>
                <td>= Quórum da 1ª convocação (50% + 1) = ((C / 2) + 1)</td>
                <td class="numero"><?= e(round(((($tot_quorum - $total_menores) / 2) + 1))) ?></td>
            </tr>
            <tr>
                <td>= Quórum da 2ª convocação (1 / 3 membros presentes) = (C * (1 / 3))</td>
                <td class="numero"><?= e(round(($tot_quorum - $total_menores) * (1 / 3))) ?></td>
            </tr>
            <tr>
                <td>Obs: Exclui os membros menores de 18 anos.</td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
</body>
</html>