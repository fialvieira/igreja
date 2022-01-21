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
    <link rel="stylesheet" href="caixa.css">
</head>
<body>
<htmlpageheader name="MyHeader1">
    <table class="header">
        <tr>
            <td width="1%"><img src="<?= RAIZ . 'arquivos/empresa_id_' . EMPRESA . '/img/logo.png' ?>" height="80"
                                width="50"></td>
            <td width="99%">
                <?= e($empresa->getNome()) ?> - <?= e($estado->getSigla()) ?><br>
                <span class="menor">Resumo Relatório Financeiro - <?= e($mes_por_extenso) ?> / <?= e($ano) ?></span>
            </td>
        </tr>
    </table>
</htmlpageheader>

<htmlpagefooter name="MyFooter1">
    <table width="100%">
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
    <div class="tabela">
        <span class="centro">ENTRADAS - SINTÉTICO</span>
        <br><br>
        <?php foreach ($mf_cat as $k => $v): ?>
            <table class="tabela_financeira">
                <thead>
                <tr>
                    <th colspan="2"><?= e($v['cat_mae_nome']) ?></th>
                </tr>
                </thead>
                <?php
                $detalhes = $caixa->caixaPorCategoriaMaeId($v['id'], 'S');
                $total = 0;
                ?>
                <tbody>
                <?php foreach ($detalhes as $key => $value): ?>
                    <?php $total += $value['valor'] ?>
                    <tr>
                        <td><?= e($value['nome']) ?></td>
                        <td class="numero"><?= e(\bd\Formatos::moeda($value['valor'])) ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="direita negrito">Sub-Total</td>
                    <td class="numero negrito">R$ <?= e(\bd\Formatos::moeda($total)) ?></td>
                </tr>
                </tbody>
            </table>
            <br>
        <?php endforeach; ?>
        <table class="tabela_financeira">
            <thead>
            <tr>
                <th class="negrito">TOTAL DE ENTRADAS</th>
                <th class="numero negrito">R$ <?= e(\bd\Formatos::moeda($receita_atual)) ?></th>
            </tr>
            </thead>
        </table>
        <br>
        <span class="centro">APURAÇÃO DE SALDO</span>
        <br><br>

        <table class="tabela_financeira">
            <tbody>
            <tr>
                <td class="top">Saldo Anterior</td>
                <td class="top numero"><?= e(\bd\Formatos::moeda(($saldo_anterior != '') ? $saldo_anterior : 0.00)) ?></td>
            </tr>
            <tr>
                <td>Entradas</td>
                <td class="numero"><?= e(\bd\Formatos::moeda(($receita_atual != '') ? $receita_atual : 0.00)) ?></td>
            </tr>
            <tr>
                <td>Saídas</td>
                <td class="numero">(<?= e(\bd\Formatos::moeda(($despesa_atual != '') ? $despesa_atual : 0.00)) ?>)</td>
            </tr>
            <tr>
                <td>Aplicações</td>
                <td class="numero">(<?= e(\bd\Formatos::moeda(($aplicacoes != '') ? $aplicacoes : 0.00)) ?>)</td>
            </tr>
            <tr>
                <td>Resgate de Aplicações</td>
                <td class="numero"><?= e(\bd\Formatos::moeda(($resgates != '') ? $resgates : 0.00)) ?></td>
            </tr>
            <tr>
                <td class="direita negrito">Sub-Total</td>
                <td class="numero negrito">R$ <?= e(\bd\Formatos::moeda($apuracao_sub_total)) ?></td>
            </tr>
            </tbody>
        </table>
        <br><br>

        <table class="tabela_financeira">
            <thead>
            <tr>
                <th colspan="2">COMPOSIÇÃO DO SALDO</th>
            </tr>
            </thead>
            <tbody>
            <?php $total = 0; ?>
            <tr>
                <td>Saldo Caixa</td>
                <td class="numero"><?= e(\bd\Formatos::moeda((count($saldo_caixa) > 0) ? $saldo_caixa[0]['saldo'] : 0.00)) ?></td>
            </tr>
            <tr>
                <td>Saldo C/C</td>
                <td class="numero"><?= e(\bd\Formatos::moeda((count($saldo_cc) > 0) ? $saldo_cc[0]['saldo'] : 0.00)) ?></td>
            </tr>
            <?php $total += ((count($saldo_caixa) > 0) ? $saldo_caixa[0]['saldo'] : 0.00) + ((count($saldo_cc) > 0) ? $saldo_cc[0]['saldo'] : 0.00); ?>
            <?php if (count($saldo_aplicacao) > 0): ?>
                <?php foreach ($saldo_aplicacao as $key => $value): ?>
                    <?php $total += $value['saldo'] ?>
                    <tr>
                        <td><?= e($value['nome']) ?></td>
                        <td class="numero"><?= e(\bd\Formatos::moeda($value['saldo'])) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            <tr>
                <td class="direita negrito cinza">Saldo Final</td>
                <td class="numero negrito cinza">R$ <?= e(\bd\Formatos::moeda($total)) ?></td>
            </tr>
            </tbody>
        </table>
    </div>
</section>
</body>
</html>